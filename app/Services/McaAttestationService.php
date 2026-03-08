<?php

namespace App\Services;

use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;

class McaAttestationService
{
    public function __construct(private MicrosoftCspClient $client) {}

    /**
     * Check if MCA has been accepted for a customer.
     * GET /v1/customers/{id}/agreements
     */
    public function isAccepted(string $customerId): bool
    {
        $agreements = $this->client->request('GET', "customers/{$customerId}/agreements");

        return collect($agreements['items'] ?? [])
            ->where('agreementType', 'MicrosoftCustomerAgreement')
            ->isNotEmpty();
    }

    /**
     * Attest MCA on behalf of customer using the enhanced API.
     * Required before placing the first order for any new customer.
     */
    public function attest(string $customerId, array $signerInfo): array
    {
        return $this->client->request('POST', "customers/{$customerId}/agreements", [
            'userId'         => $signerInfo['user_id'],
            'agreementType'  => 'MicrosoftCustomerAgreement',
            'dateAgreed'     => now()->toIso8601String(),
            'primaryContact' => [
                'firstName'   => $signerInfo['first_name'],
                'lastName'    => $signerInfo['last_name'],
                'email'       => $signerInfo['email'],
                'phoneNumber' => $signerInfo['phone'] ?? null,
            ],
        ]);
    }
}
