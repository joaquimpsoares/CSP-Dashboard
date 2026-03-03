<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Partner Center sync job (placeholder).
 *
 * IMPORTANT:
 * - Do NOT rely on session() inside queue workers.
 * - Always pass $environment + $instanceId at dispatch time.
 */
class SyncCustomersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $instanceId,
        public string $environment = 'live',
    ) {}

    public function handle(): void
    {
        Log::warning('SyncCustomersJob::handle() not yet implemented in this codebase.', [
            'instance_id' => $this->instanceId,
            'environment' => $this->environment,
        ]);
    }
}
