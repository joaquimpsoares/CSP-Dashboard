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

    public function __construct(MicrosoftCspConnection $connection, array $config)
    {
        $this->connection = $connection;
        $this->config     = $config;
        $this->http       = new GuzzleClient(['timeout' => 30]);
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
            'microsoft_csp_token:%s:%s:%s:pc',
            $this->connection->provider_id,
            $this->connection->tenant_id,
            $this->connection->token_mode
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
            'microsoft_csp_token:%s:%s:%s:graph',
            $this->connection->provider_id,
            $this->connection->tenant_id,
            $this->connection->token_mode
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
        $apiUrl  = rtrim($this->connection->api_url ?? $this->config['api_url'], '/');
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
            $this->connection->tenant_id
        );

        $params = [
            'client_id'     => $this->connection->client_id,
            'client_secret' => $this->connection->client_secret,
            'resource'      => $resource,
        ];

        if ($this->connection->token_mode === 'sam') {
            $params['grant_type']    = 'refresh_token';
            $params['refresh_token'] = $this->connection->refresh_token;
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
