<?php

namespace App\Services;

use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReconciliationService
{
    public function __construct(private MicrosoftCspClient $client) {}

    /**
     * Initiate async unbilled recon export. Returns operationId to poll.
     * v1 endpoint RETIRED March 15, 2026. This uses v2.
     */
    public function initiateUnbilledRecon(string $currencyCode = 'USD'): string
    {
        $token    = $this->client->getPartnerCenterAccessToken();
        $response = Http::withToken($token)
            ->post("{$this->v2BaseUrl()}/invoices/unbilled/lineitems", [
                'invoiceLineItemType' => 'BILLINGLINEITEMS',
                'billingProvider'     => 'all',
                'currencyCode'        => $currencyCode,
            ]);

        $data = $response->throw()->json();

        return $data['operationId'];
    }

    /**
     * Poll the async operation. Returns download URLs when ready, null if still processing.
     */
    public function getDownloadLinks(string $operationId): ?array
    {
        $token    = $this->client->getPartnerCenterAccessToken();
        $response = Http::withToken($token)
            ->get("{$this->v2BaseUrl()}/invoices/unbilled/lineitems/operations/{$operationId}");

        $status = $response->throw()->json();

        return ($status['status'] ?? '') === 'Succeeded'
            ? $status['resourceLocation']
            : null;
    }

    /**
     * Download and parse a CSV.GZIP recon file from a resourceLocation URL.
     */
    public function parseReconFile(string $downloadUrl): Collection
    {
        $compressed = Http::get($downloadUrl)->body();
        $csv        = gzdecode($compressed);
        $lines      = explode("\n", trim($csv));
        $headers    = str_getcsv(array_shift($lines));

        return collect($lines)
            ->filter()
            ->map(fn($line) => array_combine($headers, str_getcsv($line)));
    }

    /**
     * Partner Center v2 base URL, respecting sandbox vs live environment.
     */
    private function v2BaseUrl(): string
    {
        return $this->client->environment() === 'sandbox'
            ? 'https://api.sandbox.partnercenter.microsoft.com/v2'
            : 'https://api.partnercenter.microsoft.com/v2';
    }
}
