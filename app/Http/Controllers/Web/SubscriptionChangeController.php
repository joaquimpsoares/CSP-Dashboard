<?php

namespace App\Http\Controllers\Web;

use App\Models\SubscriptionScheduledChange;
use App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy;
use App\Services\MicrosoftCsp\ScheduledChangesService;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionChangeController extends Controller
{
    public function validateChange(Request $request, Subscription $subscription, NceSubscriptionPolicy $policy)
    {
        $request->validate([
            'type' => 'required|string|in:quantity,billing,term,cancel',
            'new_quantity' => 'nullable|integer|min:1',
            'new_billing_cycle' => 'nullable|string',
            'new_term_duration' => 'nullable|string',
        ]);

        $pc = $this->fetchPartnerCenterSubscription($subscription);
        $decision = $policy->evaluate($subscription, $pc, [
            'type' => $request->input('type'),
            'new_quantity' => $request->input('new_quantity'),
            'new_billing_cycle' => $request->input('new_billing_cycle'),
            'new_term_duration' => $request->input('new_term_duration'),
        ]);

        return response()->json($decision);
    }

    public function scheduleChange(Request $request, Subscription $subscription, NceSubscriptionPolicy $policy, ScheduledChangesService $scheduler)
    {
        $request->validate([
            'type' => 'required|string|in:quantity,billing,term,cancel',
            'new_quantity' => 'nullable|integer|min:1',
            'new_billing_cycle' => 'nullable|string',
            'new_term_duration' => 'nullable|string',
        ]);

        $pc = $this->fetchPartnerCenterSubscription($subscription);
        $decision = $policy->evaluate($subscription, $pc, [
            'type' => $request->input('type'),
            'new_quantity' => $request->input('new_quantity'),
            'new_billing_cycle' => $request->input('new_billing_cycle'),
            'new_term_duration' => $request->input('new_term_duration'),
        ]);

        if (($decision['mode'] ?? null) !== NceSubscriptionPolicy::MODE_SCHEDULE) {
            return response()->json([
                'ok' => false,
                'message' => 'This change is not eligible for scheduling.',
                'decision' => $decision,
            ], 422);
        }

        $payload = $decision['suggested_action']['payload'] ?? [];

        // Map request types to Partner Center scheduled change payload.
        $pcPayload = [];
        if ($request->input('type') === 'quantity') {
            $pcPayload['quantity'] = (int) ($request->input('new_quantity') ?? $payload['quantity'] ?? $subscription->amount);
        }
        if ($request->input('type') === 'billing') {
            $pcPayload['billingCycle'] = (string) ($request->input('new_billing_cycle') ?? $payload['billingCycle'] ?? $subscription->billing_period);
        }
        if ($request->input('type') === 'term') {
            $pcPayload['termDuration'] = (string) ($request->input('new_term_duration') ?? $payload['termDuration'] ?? $subscription->term);
        }
        if ($request->input('type') === 'cancel') {
            // Connector currently supports updateOnRenew scheduling; cancellation-at-renewal might not be supported via this connector.
            // Keep a local record; calling API is best-effort.
            $pcPayload['cancel'] = true;
        }

        $actor = Auth::user();

        Log::info('Scheduling subscription change', [
            'actor_id' => $actor?->id,
            'actor_email' => $actor?->email,
            'subscription_local_id' => $subscription->id,
            'pc_subscription_id' => $subscription->subscription_id,
            'decision' => $decision,
            'pc_payload' => $pcPayload,
        ]);

        $apiResponse = null;
        $status = 'pending';
        try {
            if (!isset($pcPayload['cancel'])) {
                $apiResponse = $scheduler->schedule($subscription, $pcPayload);
            } else {
                // not implemented in connector; we keep as pending and show message to user.
                $apiResponse = ['message' => 'Cancellation scheduling not implemented via connector; stored locally for manual handling.'];
            }
        } catch (\Throwable $e) {
            $status = 'failed';
            $apiResponse = ['error' => $e->getMessage()];
        }

        $row = SubscriptionScheduledChange::create([
            'subscription_id' => $subscription->id,
            'provider_id' => $subscription->provider_id ?? null,
            'customer_id' => $subscription->customer_id ?? null,
            'pc_subscription_id' => $subscription->subscription_id,
            'type' => $request->input('type'),
            'payload' => $pcPayload,
            'status' => $status,
            'effective_date' => $pc['commitmentEndDate'] ?? null,
            'requested_by_user_id' => $actor?->id,
            'requested_by_email' => $actor?->email,
            'policy_decision' => $decision,
            'api_response' => $apiResponse,
        ]);

        return response()->json([
            'ok' => $status !== 'failed',
            'scheduled_change_id' => $row->id,
            'decision' => $decision,
            'api_response' => $apiResponse,
        ]);
    }

    private function fetchPartnerCenterSubscription(Subscription $subscription): array
    {
        // Fetch latest subscription details from Partner Center via existing connector.
        // The local Subscription model already wraps Tagydes connector.
        $result = $subscription->getSubscription($subscription->customer, $subscription);

        // normalize
        if (is_array($result)) {
            return $result;
        }
        if ($result instanceof \Illuminate\Support\Collection) {
            return $result->toArray();
        }
        if (is_object($result) && method_exists($result, 'toArray')) {
            return $result->toArray();
        }
        return [];
    }
}
