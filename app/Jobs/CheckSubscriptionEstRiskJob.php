<?php

namespace App\Jobs;

use App\Subscription;
use App\Mail\EstRiskAlertMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckSubscriptionEstRiskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;
    public array $backoff = [30, 120, 300];

    public function __construct(
        public readonly string $environment = 'live',
        public readonly ?int $providerId = null
    ) {}

    public function handle(): void
    {
        // EST risk criteria (column names corrected from actual schema):
        // - autorenew = false/0         (column: autorenew, not auto_renew_enabled)
        // - expiration_data < 2026-04-01 (column: expiration_data, not commitment_end_date)
        // - expiration_data > 2025-04-01 (NCE — purchased after Apr 1 2025)
        // - status_id IN [1,2]          (1=Active, 2=Inactive/Suspended; column is status_id, not status)
        // - environment matches

        $cutoff   = Carbon::parse('2026-04-01');
        $nceStart = Carbon::parse('2025-04-01');

        $query = Subscription::withoutGlobalScopes()
            ->where('environment', $this->environment)
            ->where('autorenew', false)
            ->where('expiration_data', '<', $cutoff->toDateString())
            ->where('expiration_data', '>', $nceStart->toDateString())
            ->whereIn('status_id', [1, 2]);

        if ($this->providerId) {
            $query->whereHas('instance', function ($q) {
                $q->where('provider_id', $this->providerId);
            });
        }

        $atRisk = $query->get();

        if ($atRisk->isEmpty()) {
            Log::info('[ESTGuard] No at-risk subscriptions found', [
                'environment' => $this->environment,
                'provider_id' => $this->providerId,
            ]);
            return;
        }

        // Flag each subscription
        $ids = $atRisk->pluck('id')->toArray();
        Subscription::withoutGlobalScopes()
            ->whereIn('id', $ids)
            ->update([
                'est_risk'            => true,
                'est_risk_checked_at' => now(),
            ]);

        Log::warning('[ESTGuard] At-risk subscriptions flagged', [
            'count'       => $atRisk->count(),
            'environment' => $this->environment,
            'ids'         => $ids,
        ]);

        // Group by provider via instance and send one email per provider
        $atRisk->load('instance');

        $byProvider = $atRisk->groupBy(fn($sub) => $sub->instance?->provider_id);

        foreach ($byProvider as $providerId => $subs) {
            if (! $providerId) {
                continue;
            }

            try {
                $provider = \App\Provider::find($providerId);
                if (! $provider) {
                    continue;
                }

                $user = $provider->users()->first();
                if (! $user || ! $user->email) {
                    continue;
                }

                Mail::to($user->email)
                    ->send(new EstRiskAlertMail($provider, collect($subs), $this->environment));
            } catch (\Exception $e) {
                Log::error('[ESTGuard] Failed to send alert email', [
                    'provider_id' => $providerId,
                    'error'       => $e->getMessage(),
                ]);
            }
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('[ESTGuard] Job failed', [
            'error'       => $e->getMessage(),
            'environment' => $this->environment,
        ]);
    }
}
