<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Instance;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy;
use App\Services\MicrosoftCsp\ScheduledChangesService;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\SubscriptionService;



class SubscriptionController extends Controller
{

    use UserTrait;
    private $subscriptionRepository;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $orderRepository;



    public function __construct(ResellerRepositoryInterface $resellerRepository, OrderRepositoryInterface $orderRepository, CustomerRepositoryInterface $customerRepository, SubscriptionRepositoryInterface $subscriptionRepository, ProviderRepositoryInterface $providerRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
        $this->orderRepository = $orderRepository;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->getUserLevel() === 'Customer') {
            return view('subscriptions.customer');
        }
        return view('subscriptions.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {

        return view('subscriptions.show', compact('subscription'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $amount         = collect($request->amount)->diff(collect($subscription->amount));
        $billing_period = collect($request->billing_period)->diff(collect($subscription->billing_period));
        $status         = collect($request->status)->diff(collect($subscription->status_id));


        $order = $this->orderRepository->UpdateMSSubscription($subscription, $request);

        $subscriptions = Subscription::findOrFail($subscription->id);
        $instance = Instance::where('id', $subscription->instance_id)->first();

        Log::info('Subscription: ' . $subscriptions);
        Log::info('Instance: ' . $instance);

        $this->validate($request, [
            'amount' => 'required|integer',
        ]);

        // Resolve CSP connection for this provider
        $connection          = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client              = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        $subscriptionService = new SubscriptionService($client);

        $customerId     = $subscriptions->customer->microsoftTenantInfo->first()->tenant_id;
        $subscriptionId = $subscriptions->subscription_id;

        Log::info('MS subscription ID: ' . $subscriptionId);

        // Note: primary subscription management uses Livewire (ShowSubscription).
        // This controller method is retained as a non-Livewire fallback.

        // ── NCE guardrail check ───────────────────────────────────────────────
        // For NCE subscriptions, evaluate all immediate change requests against
        // the Partner Center policy before sending anything to the API.
        // Quantity decreases outside the 7-day window must go through scheduling;
        // billing/term changes always schedule at renewal.
        if ($subscriptions->product?->IsNCE()) {
            /** @var NceSubscriptionPolicy $policy */
            $policy = app(NceSubscriptionPolicy::class);

            // Build the smallest valid PC-data stub from what we know locally.
            // A real fetch could be added here, but we keep it lightweight and
            // rely on local data; the conservative policy default handles unknown windows.
            $pcStub = [
                'quantity'             => $subscriptions->amount,
                'billingCycle'         => $subscriptions->billing_period,
                'termDuration'         => $subscriptions->term,
                'CancellationAllowedUntil' => $subscriptions->CancellationAllowedUntil,
                'commitmentEndDate'    => $subscriptions->expiration_data,
            ];

            $changeType = 'quantity';
            $changeReq  = [
                'type'         => 'quantity',
                'new_quantity' => (int) $request->amount,
            ];

            if (!$amount->isEmpty() && !$billing_period->isEmpty()) {
                // Both changed — evaluate the more restrictive: billing (always schedules).
                $changeType = 'billing';
                $changeReq  = ['type' => 'billing', 'new_billing_cycle' => $request->billing_period];
            } elseif (!$billing_period->isEmpty()) {
                $changeType = 'billing';
                $changeReq  = ['type' => 'billing', 'new_billing_cycle' => $request->billing_period];
            }

            if ($request->scheduled !== 'true') {
                // Only block/redirect if the caller is NOT already requesting scheduling.
                $decision = $policy->evaluate($subscriptions, $pcStub, $changeReq);

                if ($decision['mode'] === NceSubscriptionPolicy::MODE_SCHEDULE) {
                    // Auto-schedule on the caller's behalf and redirect back with a message.
                    try {
                        $scheduler = app(ScheduledChangesService::class);
                        $pcPayload = $decision['suggested_action']['payload'] ?? [];
                        $scheduler->schedule($subscriptions, $pcPayload);
                        $subscriptions->update(['changes_on_renew' => $pcPayload]);
                        $order->update(['order_status_id' => 4]);
                        return redirect()->back()->with(
                            'warning',
                            $decision['reason_message']
                            . ' The change has been scheduled for renewal automatically.'
                        );
                    } catch (Exception $e) {
                        $order->update(['order_status_id' => 3]);
                        return Redirect::back()->with('danger', 'Error scheduling change: ' . $e->getMessage());
                    }
                }

                if ($decision['mode'] === NceSubscriptionPolicy::MODE_BLOCKED) {
                    $order->update(['order_status_id' => 3]);
                    return Redirect::back()->with('danger', $decision['reason_message']);
                }
            }
        }
        // ── end NCE guardrail ─────────────────────────────────────────────────

        if ($subscriptions->product->IsNCE() && $request->scheduled === 'true') {
            try {
                $subscriptionService->scheduleChange($customerId, $subscriptionId, [
                    'billingCycle' => $request->get('billingCycle', $subscriptions->billing_period),
                    'quantity'     => (int) $request->get('amount', $subscriptions->amount),
                ]);
                $subscriptions->update(['changes_on_renew' => ['amount' => $request->amount]]);
            } catch (Exception $e) {
                $order->update(['order_status_id' => 3]);
                return Redirect::back()->with('danger', 'Error scheduling change: ' . $e->getMessage());
            }
        } elseif ($status->isempty() &&  $billing_period->isempty() && !$amount->isempty()) { //change only amount
            try {
                $subscriptionService->updateQuantity($customerId, $subscriptionId, (int) $request->amount);
                $subscriptions->update(['changes_on_renew' => null, 'amount' => $request->amount]);
                Log::info('License changed: ' . $request->amount);
            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
                $order->update(['order_status_id' => 3]);
                return Redirect::back()->with('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
            }
        } elseif ($status->isempty() &&  !$billing_period->isempty() && $amount->isempty()) { //Change billing period
            try {
                $subscriptionService->updateBillingCycle($customerId, $subscriptionId, $request->billing_period);
                $subscriptions->update(['changes_on_renew' => null, 'billing_period' => $request->billing_period]);
                Log::info('Billing Cycle changed: ' . $request->billing_period);
            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
                $order->update(['order_status_id' => 3]);
                return Redirect::back()->with('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
            }
        } elseif ($status->isempty() &&  !$billing_period->isempty() && !$amount->isempty()) { //Change billing period AND AMOUNT
            try {
                $subscriptionService->updateBillingCycle($customerId, $subscriptionId, $request->billing_period);
                $subscriptionService->updateQuantity($customerId, $subscriptionId, (int) $request->amount);
                $subscriptions->update([
                    'changes_on_renew' => null,
                    'billing_period'   => $request->billing_period,
                    'amount'           => $request->amount
                ]);

                $order->update(['order_status_id' => 4]);
                Log::info('Billing Cycle changed To: ' . $request->billing_period . ' and amount changed to ' . $request->amount);
            } catch (Exception $e) {
                $order->update(['order_status_id' => 3]);
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
                return Redirect::back()->with('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
            }
        } elseif (!$status->isempty()) {
            try {
                if ($subscriptions->billing_period === 'one_time') {
                    $subscriptionService->cancelSubscription($customerId, $subscriptionId);
                    $statusId = ($request->status == 'active') ? 1 : 3;
                    $subscriptions->update(['status_id' => $statusId]);
                } else {
                    $subscriptionService->updateStatus($customerId, $subscriptionId, $request->status);
                    $statusId = ($request->status == 'active') ? 1 : 2;
                    $subscriptions->update(['status_id' => $statusId]);
                }

                Log::info('Status changed: ' . $request->status);
            } catch (Exception $e) {
                $order->update(['order_status_id' => 3]);
                Log::info('Error Placing order to Microsoft: ' . $e->getMessage());
                return Redirect::back()->with('danger', 'Error Placing order to Microsoft: ' . $e->getMessage());
            }
        } else {
            return Redirect::back()->with('danger', 'nothing to do');
        }

        $order->update(['order_status_id' => 4]);
        $order->update(['subscription_id' => $subscriptions->id]);
        return redirect()->back()->with('success', 'Subscription updated succesfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
