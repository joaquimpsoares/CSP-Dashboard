<?php

namespace Modules\MicrosoftCspConnection\Services;

class CustomerService
{
    private MicrosoftCspClient $client;

    public function __construct(MicrosoftCspClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all CSP customers for this partner.
     *
     * @param  array $params  Optional query parameters (e.g. ['size' => 100, 'filter' => '...'])
     * @return array          Partner Center customer collection response
     */
    public function list(array $params = []): array
    {
        return $this->client->request('GET', 'customers', [], $params);
    }

    /**
     * Retrieve a single customer by their Microsoft tenant ID.
     *
     * @param  string $customerId  Customer tenant ID (Microsoft-assigned GUID)
     * @return array               Customer resource
     */
    public function get(string $customerId): array
    {
        return $this->client->request('GET', "customers/{$customerId}");
    }

    /**
     * Create a new CSP customer.
     *
     * Accepted $data fields (mapped from local app fields):
     *   company      → companyProfile.companyName
     *   domain       → companyProfile.domain
     *   culture      → companyProfile.culture  (e.g. "EN-US")
     *   language     → companyProfile.language (e.g. "en")
     *   address      → companyProfile.address.addressLine1
     *   city         → companyProfile.address.city
     *   province     → companyProfile.address.state
     *   postalCode   → companyProfile.address.postalCode
     *   country      → companyProfile.address.country  (ISO 3166-2, e.g. "PT")
     *   firstName    → primaryContact.firstName
     *   lastName     → primaryContact.lastName
     *   email        → primaryContact.email
     *   telephone    → primaryContact.phoneNumber
     *
     * @param  array $data  Flat array of customer fields (see above)
     * @return array        Created customer resource (includes id = tenant GUID)
     */
    public function create(array $data): array
    {
        $payload = [
            'companyProfile' => [
                'companyName' => $data['company'] ?? '',
                'domain'      => $data['domain']  ?? '',
                'culture'     => $data['culture']  ?? 'EN-US',
                'language'    => $data['language'] ?? 'en',
                'address'     => [
                    'addressLine1' => $data['address']    ?? '',
                    'city'         => $data['city']        ?? '',
                    'state'        => $data['province']    ?? '',
                    'postalCode'   => $data['postalCode']  ?? '',
                    'country'      => $data['country']     ?? '',
                ],
            ],
            'primaryContact' => [
                'firstName'   => $data['firstName'] ?? '',
                'lastName'    => $data['lastName']  ?? '',
                'email'       => $data['email']     ?? '',
                'phoneNumber' => $data['telephone'] ?? '',
            ],
        ];

        return $this->client->request('POST', 'customers', $payload);
    }

    /**
     * Get the education/government qualifications for a customer.
     *
     * @param  string $customerId  Customer tenant ID
     * @return array               Qualifications resource
     */
    public function getQualifications(string $customerId): array
    {
        return $this->client->request('GET', "customers/{$customerId}/qualifications");
    }

    /**
     * Update the qualification for a customer.
     *
     * @param  string $customerId    Customer tenant ID
     * @param  string $qualification Qualification type (e.g. "Education")
     * @return array                 Updated qualification resource
     */
    public function updateQualification(string $customerId, string $qualification): array
    {
        return $this->client->request(
            'POST',
            "customers/{$customerId}/qualifications",
            ['qualification' => $qualification]
        );
    }

    /**
     * Check whether a tenant is already a customer of this CSP partner.
     * Returns true when GET /customers/{tenantId} succeeds (200 OK).
     * Returns false on 404 (not a customer / no commerce relationship).
     *
     * @param  string $tenantId  Azure AD tenant ID of the domain being checked
     * @return bool
     */
    public function checkRelationship(string $tenantId): bool
    {
        try {
            $this->client->request('GET', "customers/{$tenantId}");
            return true;
        } catch (\RuntimeException $e) {
            return false;
        }
    }
}
