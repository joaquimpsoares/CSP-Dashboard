<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KeyVaultService
{
    private function getAccessToken(): string
    {
        return Cache::remember('keyvault_access_token', 3000, function () {
            $response = Http::asForm()->post(
                'https://login.microsoftonline.com/' . config('keyvault.tenant_id') . '/oauth2/v2.0/token',
                [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => config('keyvault.client_id'),
                    'client_secret' => config('keyvault.client_secret'),
                    'scope'         => 'https://vault.azure.net/.default',
                ]
            );

            if ($response->failed()) {
                Log::error('KeyVault error', [
                    'status' => $response->status(),
                    'error'  => $response->json('error.code') ?? 'unknown',
                    // body only in debug mode
                    'detail' => config('app.debug') ? $response->body() : null,
                ]);

                throw new \RuntimeException(
                    "Key Vault operation failed [{$response->status()}]: " . ($response->json('error.code') ?? 'unknown')
                );
            }

            return (string) $response->json('access_token');
        });
    }

    public function getSecret(string $secretName): string
    {
        if (! preg_match('/^[0-9a-zA-Z-]+$/', $secretName)) {
            throw new \InvalidArgumentException(
                'Invalid Key Vault secret name. Only alphanumeric characters and hyphens are allowed.'
            );
        }

        $token    = $this->getAccessToken(); // this one stays cached
        $endpoint = rtrim((string) config('keyvault.endpoint'), '/');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get("{$endpoint}/secrets/" . rawurlencode($secretName), [
            'api-version' => '7.4',
        ]);

        if ($response->failed()) {
            Log::error('KeyVault error', [
                'status' => $response->status(),
                'error'  => $response->json('error.code') ?? 'unknown',
                // body only in debug mode
                'detail' => config('app.debug') ? $response->body() : null,
            ]);

            throw new \RuntimeException(
                "Key Vault operation failed [{$response->status()}]: " . ($response->json('error.code') ?? 'unknown')
            );
        }

        return (string) $response->json('value');
    }

    public function setSecret(string $secretName, string $value): void
    {
        if (! preg_match('/^[0-9a-zA-Z-]+$/', $secretName)) {
            throw new \InvalidArgumentException(
                'Invalid Key Vault secret name. Only alphanumeric characters and hyphens are allowed.'
            );
        }

        $secretName = rawurlencode($secretName);

        $token    = $this->getAccessToken();
        $endpoint = rtrim((string) config('keyvault.endpoint'), '/');

        $url = "{$endpoint}/secrets/{$secretName}?api-version=7.4";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Content-Type'  => 'application/json',
        ])->put($url, [
            'value' => $value,
        ]);

        if ($response->failed()) {
            Log::error('KeyVault error', [
                'status' => $response->status(),
                'error'  => $response->json('error.code') ?? 'unknown',
                // body only in debug mode
                'detail' => config('app.debug') ? $response->body() : null,
            ]);

            throw new \RuntimeException(
                "Key Vault operation failed [{$response->status()}]: " . ($response->json('error.code') ?? 'unknown')
            );
        }
    }
}

