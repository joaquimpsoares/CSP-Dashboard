<?php

namespace App\Services\MicrosoftCsp;

use App\Instance;
use App\Subscription;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\SubscriptionService;

class ScheduledChangesService
{
    /**
     * Schedule renewal-time changes via the MicrosoftCspConnection module.
     *
     * @param  Subscription $local    Local subscription record
     * @param  array        $payload  Change payload: quantity, billingCycle, termDuration, product
     * @return array                  Partner Center response
     */
    public function schedule(Subscription $local, array $payload): array
    {
        $subscriptionService = $this->resolveService($local);

        $customerId     = $local->customer->microsoftTenantInfo->first()->tenant_id;
        $subscriptionId = $local->subscription_id;

        $sanitized = Arr::only($payload, ['quantity', 'billingCycle', 'termDuration', 'product']);

        Log::info('Scheduled change request', [
            'subscription_local_id' => $local->id,
            'pc_subscription_id'    => $subscriptionId,
            'payload'               => $sanitized,
        ]);

        return $subscriptionService->scheduleChange($customerId, $subscriptionId, $sanitized);
    }

    /**
     * Remove all scheduled changes for a subscription.
     *
     * @param  Subscription $local  Local subscription record
     * @return array                Partner Center response
     */
    public function removeSchedule(Subscription $local): array
    {
        $subscriptionService = $this->resolveService($local);

        $customerId     = $local->customer->microsoftTenantInfo->first()->tenant_id;
        $subscriptionId = $local->subscription_id;

        Log::info('Remove scheduled change request', [
            'subscription_local_id' => $local->id,
            'pc_subscription_id'    => $subscriptionId,
        ]);

        return $subscriptionService->removeScheduledChange($customerId, $subscriptionId);
    }

    /**
     * Resolve a SubscriptionService instance for the provider that owns the subscription.
     */
    private function resolveService(Subscription $local): SubscriptionService
    {
        $instance   = Instance::query()->findOrFail($local->instance_id);
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));

        return new SubscriptionService($client);
    }
}
