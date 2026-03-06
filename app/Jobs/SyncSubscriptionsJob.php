<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $instanceId,
        public string $environment = 'live',
    ) {}

    public function handle(): void
    {
        Log::warning('SyncSubscriptionsJob::handle() not yet implemented in this codebase.', [
            'instance_id' => $this->instanceId,
            'environment' => $this->environment,
        ]);
    }
}
