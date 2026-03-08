<?php

namespace App\Jobs;

use App\Instance;
use App\Services\ReconciliationService;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DownloadReconFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int   $tries   = 3;
    public int   $timeout = 300;
    public array $backoff  = [60, 180, 600];

    public function __construct(
        private string $environment,
        private int    $instanceId,
        private string $operationId,
        private string $currencyCode = 'USD',
    ) {}

    public function handle(): void
    {
        $instance   = Instance::findOrFail($this->instanceId);
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'), $this->environment);
        $recon      = new ReconciliationService($client);

        $links = $recon->getDownloadLinks($this->operationId);

        if ($links === null) {
            Log::info('Recon operation still processing, releasing back to queue', [
                'operation_id' => $this->operationId,
                'environment'  => $this->environment,
                'instance_id'  => $this->instanceId,
            ]);
            $this->release(120);
            return;
        }

        foreach ($links as $url) {
            $rows = $recon->parseReconFile($url);

            Log::info('Recon file downloaded', [
                'environment' => $this->environment,
                'instance_id' => $this->instanceId,
                'rows'        => $rows->count(),
            ]);

            // TODO: persist $rows to recon_line_items table
            // Insert with environment + instance_id scope
        }
    }

    public function failed(\Throwable $e): void
    {
        Log::error('DownloadReconFileJob failed permanently', [
            'environment'  => $this->environment,
            'instance_id'  => $this->instanceId,
            'operation_id' => $this->operationId,
            'error'        => $e->getMessage(),
        ]);
    }
}
