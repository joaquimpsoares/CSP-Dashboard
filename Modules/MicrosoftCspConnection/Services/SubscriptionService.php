<?php

namespace Modules\MicrosoftCspConnection\Services;

class SubscriptionService
{
    private MicrosoftCspClient $client;

    public function __construct(MicrosoftCspClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all subscriptions for a customer.
     *
     * @param  string $customerId  Customer tenant ID
     * @param  array  $params      Optional query params
     * @return array               Partner Center subscription collection response
     */
    public function listByCustomer(string $customerId, array $params = []): array
    {
        return $this->client->request('GET', "customers/{$customerId}/subscriptions", [], $params);
    }

    /**
     * Get a single subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @return array                   Subscription resource
     */
    public function get(string $customerId, string $subscriptionId): array
    {
        return $this->client->request('GET', "customers/{$customerId}/subscriptions/{$subscriptionId}");
    }

    /**
     * Update the seat count (quantity) of a subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  int    $quantity        New seat count
     * @return array                   Updated subscription resource
     */
    public function updateQuantity(string $customerId, string $subscriptionId, int $quantity): array
    {
        return $this->client->request(
            'PATCH',
            "customers/{$customerId}/subscriptions/{$subscriptionId}",
            ['quantity' => $quantity]
        );
    }

    /**
     * Update the billing cycle of a subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  string $billingCycle    New billing cycle (e.g. "monthly", "annual", "none")
     * @return array                   Updated subscription resource
     */
    public function updateBillingCycle(string $customerId, string $subscriptionId, string $billingCycle): array
    {
        return $this->client->request(
            'PATCH',
            "customers/{$customerId}/subscriptions/{$subscriptionId}",
            ['billingCycle' => $billingCycle]
        );
    }

    /**
     * Update the status of a subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  string $status          New status (e.g. "active", "suspended")
     * @return array                   Updated subscription resource
     */
    public function updateStatus(string $customerId, string $subscriptionId, string $status): array
    {
        return $this->client->request(
            'PATCH',
            "customers/{$customerId}/subscriptions/{$subscriptionId}",
            ['status' => $status]
        );
    }

    /**
     * Generic PATCH update — send any subscription fields to Partner Center.
     * Useful for combined updates (e.g. quantity + autoRenewEnabled in one call).
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  array  $data            Fields to update (Partner Center camelCase)
     * @return array                   Updated subscription resource
     */
    public function update(string $customerId, string $subscriptionId, array $data): array
    {
        return $this->client->request(
            'PATCH',
            "customers/{$customerId}/subscriptions/{$subscriptionId}",
            $data
        );
    }

    /**
     * Cancel an NCE subscription (sends DELETE to Partner Center).
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @return array                   Response (empty on success)
     */
    public function cancelSubscription(string $customerId, string $subscriptionId): array
    {
        return $this->client->request(
            'DELETE',
            "customers/{$customerId}/subscriptions/{$subscriptionId}"
        );
    }

    /**
     * Create a scheduled change (updateOnRenew) for an NCE subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  array  $data            Scheduled change payload (product, billingCycle, quantity, termDuration)
     * @return array                   Scheduled change response
     */
    public function scheduleChange(string $customerId, string $subscriptionId, array $data): array
    {
        return $this->client->request(
            'POST',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/scheduledChanges",
            $data
        );
    }

    /**
     * Remove all scheduled changes for a subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @return array                   Response
     */
    public function removeScheduledChange(string $customerId, string $subscriptionId): array
    {
        return $this->client->request(
            'DELETE',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/scheduledChanges"
        );
    }

    /**
     * Validate whether a legacy subscription is eligible for NCE migration.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @return array                   Validation result
     */
    public function validateMigration(string $customerId, string $subscriptionId): array
    {
        return $this->client->request(
            'POST',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/migrateToNewCommerce/validate"
        );
    }

    /**
     * Create an NCE migration for a legacy subscription.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Subscription ID
     * @param  array  $data            Migration data (quantity, billingCycle, termDuration, etc.)
     * @return array                   Migration result
     */
    public function createMigration(string $customerId, string $subscriptionId, array $data): array
    {
        return $this->client->request(
            'POST',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/migrateToNewCommerce",
            $data
        );
    }

    /**
     * Get the status of an NCE migration.
     *
     * @param  string $customerId      Customer tenant ID
     * @param  string $subscriptionId  Original subscription ID
     * @param  string $migrationId     Migration ID
     * @return array                   Migration status
     */
    public function getMigration(string $customerId, string $subscriptionId, string $migrationId): array
    {
        return $this->client->request(
            'GET',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/migrateToNewCommerce/{$migrationId}"
        );
    }
}
