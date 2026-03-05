<?php

namespace Modules\MicrosoftCspConnection\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Microsoft\Graph\Graph;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class MicrosoftCspClient
{
    private MicrosoftCspConnection $connection;
    private array $config;
    private GuzzleClient $http;
    private string $environment;

    public function __construct(MicrosoftCspConnection $connection, array $config, ?string $environment = null)
    {
        $this->connection  = $connection;
        $this->config      = $config;
        $this->http        = new GuzzleClient(['timeout' => 30]);
        $this->environment = $environment ?? session('environment', 'live');
    }

    // -------------------------------------------------------------------------
    // Token acquisition — Partner Center resource
    // -------------------------------------------------------------------------

    /**
     * Acquire (or return cached) an OAuth2 access token scoped to the
     * Partner Center resource.  Supports two grant types:
     *   - app_only: client_credentials
     *   - sam:      refresh_token (Secure Application Model)
     *
     * @throws RuntimeException on authentication failure
     */
    public function getPartnerCenterAccessToken(): string
    {
        // Cache key includes resource discriminator so PC and Graph tokens never collide
        $cacheKey = sprintf(
            'microsoft_csp_token:%s:%s:%s:%s:pc',
            $this->connection->provider_id,
            $this->effectiveTenantId(),
            $this->connection->token_mode,
            $this->environment
        );

        return Cache::remember($cacheKey, $this->tokenTtl(), function () {
            return $this->fetchToken($this->config['partner_center_resource']);
        });
    }

    // -------------------------------------------------------------------------
    // Microsoft Graph SDK client
    // -------------------------------------------------------------------------

    /**
     * Return a configured Microsoft Graph SDK instance, authenticating against
     * the Graph resource separately from the Partner Center token.
     *
     * @throws RuntimeException on authentication failure
     */
    public function getGraphClient(): Graph
    {
        // Separate cache key entry for Graph resource (different audience from PC)
        $cacheKey = sprintf(
            'microsoft_csp_token:%s:%s:%s:%s:graph',
            $this->connection->provider_id,
            $this->effectiveTenantId(),
            $this->connection->token_mode,
            $this->environment
        );

        $token = Cache::remember($cacheKey, $this->tokenTtl(), function () {
            return $this->fetchToken($this->config['graph_resource']);
        });

        $graph = new Graph();
        $graph->setAccessToken($token);

        return $graph;
    }

    // -------------------------------------------------------------------------
    // HTTP requests to Partner Center REST API
    // -------------------------------------------------------------------------

    /**
     * Make an authenticated HTTP request to the Partner Center REST API.
     *
     * @param  string $method  HTTP verb (GET, POST, PATCH, DELETE)
     * @param  string $path    Endpoint path relative to /v1/ (e.g. "customers")
     * @param  array  $data    Request body (for POST/PATCH)
     * @param  array  $query   Query string parameters
     * @return array           Decoded JSON response body
     *
     * @throws RuntimeException on HTTP or API error
     */
    public function request(string $method, string $path, array $data = [], array $query = []): array
    {
        $token   = $this->getPartnerCenterAccessToken();
        $apiUrl  = rtrim($this->getPartnerCenterBaseUrl(), '/');
        $url     = "{$apiUrl}/v1/{$path}";

        $correlationId = Uuid::uuid4()->toString();

        $headers = [
            'Authorization'       => "Bearer {$token}",
            'Accept'              => 'application/json',
            'Content-Type'        => 'application/json',
            'MS-Contract-Version' => 'v1',
            'MS-RequestId'        => Uuid::uuid4()->toString(),
            'MS-CorrelationId'    => $correlationId,
            'X-Locale'            => 'en-US',
        ];

        // SAM mode: ask Partner Center to validate MFA compliance
        if ($this->connection->token_mode === 'sam') {
            $headers['ValidateMfa'] = 'true';
        }

        $options = ['headers' => $headers];

        if (! empty($query)) {
            $options['query'] = $query;
        }

        if (! empty($data)) {
            $options['json'] = $data;
        }

        try {
            $response = $this->http->request($method, $url, $options);
        } catch (ClientException | ServerException $e) {
            $status = $e->getResponse()->getStatusCode();
            $body   = (string) $e->getResponse()->getBody();

            Log::error('MicrosoftCspClient API error', [
                'method'         => $method,
                'url'            => $url,
                'status'         => $status,
                'response'       => $body,
                'provider'       => $this->connection->provider_id,
                'tenant'         => $this->connection->tenant_id,
                'correlationId'  => $correlationId,
            ]);

            throw new RuntimeException(
                "Microsoft Partner Center API error {$status}: {$body}",
                $status
            );
        }

        // Track MFA compliance when Partner Center returns the header
        if ($this->connection->token_mode === 'sam') {
            $mfaHeader = $response->getHeaderLine('isMfaCompliant');

            if ($mfaHeader !== '') {
                $this->connection->update([
                    'mfa_compliant'  => filter_var($mfaHeader, FILTER_VALIDATE_BOOLEAN),
                    'mfa_checked_at' => now(),
                ]);
            }
        }

        $body = (string) $response->getBody();

        return $body !== '' ? (array) json_decode($body, true) : [];
    }

    // -------------------------------------------------------------------------
    // Environment + credentials
    // -------------------------------------------------------------------------

    public function environment(): string
    {
        return $this->environment;
    }

    private function getPartnerCenterBaseUrl(): string
    {
        if (! empty($this->connection->api_url)) {
            return $this->connection->api_url;
        }

        return $this->environment === 'sandbox'
            ? 'https://api.sandbox.partnercenter.microsoft.com'
            : 'https://api.partnercenter.microsoft.com';
    }

    private function effectiveTenantId(): string
    {
        $tenant = $this->environment === 'sandbox'
            ? ($this->connection->sandbox_tenant_id ?? null)
            : ($this->connection->tenant_id ?? null);

        if (empty($tenant)) {
            throw new RuntimeException("Microsoft CSP connection missing tenant_id for environment '{$this->environment}'.");
        }

        return $tenant;
    }

    private function effectiveClientId(): string
    {
        $id = $this->environment === 'sandbox'
            ? ($this->connection->sandbox_client_id ?? null)
            : ($this->connection->client_id ?? null);

        if (empty($id)) {
            throw new RuntimeException("Microsoft CSP connection missing client_id for environment '{$this->environment}'.");
        }

        return $id;
    }

    private function effectiveClientSecret(): string
    {
        $secret = $this->environment === 'sandbox'
            ? ($this->connection->sandbox_client_secret ?? null)
            : ($this->connection->client_secret ?? null);

        if (empty($secret)) {
            throw new RuntimeException("Microsoft CSP connection missing client_secret for environment '{$this->environment}'.");
        }

        return $secret;
    }

    private function effectiveRefreshToken(): ?string
    {
        if ($this->connection->token_mode !== 'sam') {
            return null;
        }

        // Sandbox stays as-is (no Key Vault support yet)
        if ($this->environment === 'sandbox') {
            $raw = $this->connection->getRawOriginal('sandbox_refresh_token');

            if (empty($raw)) {
                throw new RuntimeException("Microsoft CSP connection missing refresh_token for environment '{$this->environment}'.");
            }

            return decrypt($raw);
        }

        return $this->getRefreshToken();
    }

    private function getRefreshToken(): string
    {
        if (! empty($this->connection->key_vault_secret_name)) {
            return app(\App\Services\KeyVaultService::class)
                ->getSecret($this->connection->key_vault_secret_name);
        }

        $raw = $this->connection->getRawOriginal('refresh_token');

        if (empty($raw)) {
            throw new RuntimeException("Microsoft CSP connection missing refresh_token for environment '{$this->environment}'.");
        }

        return decrypt($raw);
    }

    // -------------------------------------------------------------------------
    // Internal helpers
    // -------------------------------------------------------------------------

    /**
     * POST to the Azure AD OAuth2 token endpoint and return the access token string.
     *
     * @param  string $resource  The target resource / audience
     * @return string            Raw access token
     *
     * @throws RuntimeException on failure
     */
    private function fetchToken(string $resource): string
    {
        if (! $this->connection->isReady()) {
            throw new RuntimeException(
                "Microsoft CSP connection for provider {$this->connection->provider_id} "
                . "is not ready (incomplete credentials for mode '{$this->connection->token_mode}')."
            );
        }

        $tokenUrl = sprintf(
            '%s/%s/oauth2/token',
            rtrim($this->config['auth_url'], '/'),
            $this->effectiveTenantId()
        );

        $params = [
            'client_id'     => $this->effectiveClientId(),
            'client_secret' => $this->effectiveClientSecret(),
            'resource'      => $resource,
        ];

        if ($this->connection->token_mode === 'sam') {
            $params['grant_type']    = 'refresh_token';
            $params['refresh_token'] = $this->effectiveRefreshToken();
        } else {
            $params['grant_type'] = 'client_credentials';
        }

        try {
            $response = $this->http->post($tokenUrl, ['form_params' => $params]);
        } catch (ClientException | ServerException $e) {
            $body = (string) $e->getResponse()->getBody();

            Log::error('MicrosoftCspClient token error', [
                'provider' => $this->connection->provider_id,
                'tenant'   => $this->connection->tenant_id,
                'mode'     => $this->connection->token_mode,
                'resource' => $resource,
                'response' => $body,
            ]);

            throw new RuntimeException(
                "Failed to acquire Microsoft CSP access token: {$body}"
            );
        }

        $data = json_decode((string) $response->getBody(), true);

        if (empty($data['access_token'])) {
            throw new RuntimeException('Microsoft CSP token response did not contain an access_token.');
        }

        // Refresh token rotation (SAM only): Microsoft may return a new refresh_token alongside access_token.
        if ($this->connection->token_mode === 'sam' && ! empty($data['refresh_token'])) {
            $newRefreshToken = (string) $data['refresh_token'];

            if (! empty($this->connection->key_vault_secret_name)) {
                // Update the secret in Key Vault
                app(\App\Services\KeyVaultService::class)
                    ->setSecret($this->connection->key_vault_secret_name, $newRefreshToken);
            } else {
                // Update encrypted value in DB (model has encrypted cast, so store plaintext)
                $this->connection->update([
                    'refresh_token' => $newRefreshToken,
                ]);
            }
        }

        return $data['access_token'];
    }

    /**
     * Calculate cache TTL in seconds.
     * Uses expires_in from the token response if provided, with a 60-second safety margin.
     * Falls back to 3300 s (55 min) as a safe default for 3600 s tokens.
     *
     * @param int|null $expiresIn  Value of expires_in from token response (seconds)
     */
    private function tokenTtl(?int $expiresIn = null): int
    {
        if ($expiresIn !== null && $expiresIn > 120) {
            return $expiresIn - 60;
        }

        return 3300; // 55 minutes — safe default for standard 3600-second tokens
    }
}
