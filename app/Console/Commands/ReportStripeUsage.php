<?php

namespace App\Console\Commands;

use App\Provider;
use App\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\SubscriptionItem;

class ReportStripeUsage extends Command
{
    protected $signature   = 'stripe:report-usage';
    protected $description = 'Report active Microsoft CSP subscription counts to Stripe metered billing';

    public function handle(): int
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $providers = Provider::whereNotNull('stripe_subscription_item_id')
            ->where('stripe_status', 'active')
            ->get();

        if ($providers->isEmpty()) {
            $this->info('No active providers with Stripe metered items — nothing to report.');
            return self::SUCCESS;
        }

        $timestamp = now()->timestamp;
        $reported  = 0;
        $failed    = 0;

        foreach ($providers as $provider) {
            try {
                // Count active Microsoft CSP subscriptions owned by this provider's customers.
                $customerIds = $provider->getMyCustomersId();
                $activeCount = Subscription::where('status_id', 1)
                    ->whereIn('customer_id', $customerIds)
                    ->count();

                // 'set' replaces the current period quantity (idempotent for repeated runs).
                SubscriptionItem::createUsageRecord(
                    $provider->stripe_subscription_item_id,
                    [
                        'quantity'  => $activeCount,
                        'timestamp' => $timestamp,
                        'action'    => 'set',
                    ]
                );

                $this->line(
                    "  ✓ Provider {$provider->id} ({$provider->company_name}): {$activeCount} active subscriptions reported."
                );

                Log::info('stripe:report-usage — recorded', [
                    'provider_id' => $provider->id,
                    'quantity'    => $activeCount,
                ]);

                $reported++;
            } catch (\Throwable $e) {
                $this->error("  ✗ Provider {$provider->id}: {$e->getMessage()}");

                Log::error('stripe:report-usage — failed', [
                    'provider_id' => $provider->id,
                    'error'       => $e->getMessage(),
                ]);

                $failed++;
            }
        }

        $this->info("Done — reported: {$reported}, failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
