<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;

class CheckRefreshTokenAge implements ShouldQueue
{
    public int $tries = 3;
    public int $timeout = 120;
    public array $backoff = [30, 120, 300];

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $threshold = Carbon::now()->subDays(75);

        $connections = MicrosoftCspConnection::query()
            ->whereNull('key_vault_secret_name')
            ->where('token_mode', 'sam')
            ->where('updated_at', '<', $threshold)
            ->with('provider.users')
            ->get();

        foreach ($connections as $connection) {
            $provider = $connection->provider;
            $email    = $provider?->users()?->first()?->email;

            $message = sprintf(
                'Microsoft CSP refresh token for provider_id=%s connection_id=%s has not rotated since %s (>= 75 days). Partner Center refresh tokens expire at ~90 days; connection may require attention.',
                (string) $connection->provider_id,
                (string) $connection->id,
                (string) $connection->updated_at
            );

            Log::warning($message);

            if (! empty($email)) {
                Mail::raw($message, function ($m) use ($email) {
                    $m->to($email)->subject('Action needed: Microsoft CSP Partner Center connection refresh token aging');
                });
            }
        }
    }

    public function failed(\Throwable $e): void
    {
        \Illuminate\Support\Facades\Log::error(static::class . ' failed permanently', [
            'error'       => $e->getMessage(),
            'environment' => property_exists($this, 'environment') ? $this->environment : 'unknown',
            'instance_id' => property_exists($this, 'instanceId') ? $this->instanceId : null,
        ]);
    }
}
