<?php

namespace Modules\MicrosoftCspConnection\Services;

use App\Provider;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use RuntimeException;

class MicrosoftCspResolver
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Resolve the active MicrosoftCspClient for the given Provider.
     *
     * Loads the first connection record associated with the provider.
     * Throws a clear error if no connection record exists.
     *
     * @throws RuntimeException if no connection is configured for the provider
     */
    public function forProvider(Provider $provider): MicrosoftCspClient
    {
        $connection = MicrosoftCspConnection::where('provider_id', $provider->id)->first();

        if (! $connection) {
            throw new RuntimeException(
                "No Microsoft CSP connection found for provider #{$provider->id}. "
                . 'Please create a connection record in microsoft_csp_connections.'
            );
        }

        return new MicrosoftCspClient($connection, $this->config);
    }

    /**
     * Resolve the active MicrosoftCspClient by provider ID directly.
     *
     * @throws RuntimeException if no connection is configured for the provider
     */
    public function forProviderId(int $providerId): MicrosoftCspClient
    {
        $connection = MicrosoftCspConnection::where('provider_id', $providerId)->first();

        if (! $connection) {
            throw new RuntimeException(
                "No Microsoft CSP connection found for provider #{$providerId}. "
                . 'Please create a connection record in microsoft_csp_connections.'
            );
        }

        return new MicrosoftCspClient($connection, $this->config);
    }

    /**
     * Build a MicrosoftCspClient directly from a connection record.
     * Useful in Jobs where the connection is already loaded.
     */
    public function fromConnection(MicrosoftCspConnection $connection): MicrosoftCspClient
    {
        return new MicrosoftCspClient($connection, $this->config);
    }
}
