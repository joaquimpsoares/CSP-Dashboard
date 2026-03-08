<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DownloadReconFileJob implements ShouldQueue
{
    public int $tries = 3;
    public int $timeout = 120;
    public array $backoff = [30, 120, 300];

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $instanceId,
        public string $environment = 'live',
    ) {}

    public function handle(): void
    {
        Log::warning('DownloadReconFileJob::handle() not yet implemented in this codebase.', [
            'instance_id' => $this->instanceId,
            'environment' => $this->environment,
        ]);
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
