<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
                throw new \RuntimeException('Failed to get Key Vault access token: ' . $response->body());
            }

            return (string) $response->json('access_token');
        });
    }

    public function getSecret(string $secretName): string
    {
        return Cache::remember("keyvault_secret_{$secretName}", 3300, function () use ($secretName) {
            $token    = $this->getAccessToken();
            $endpoint = rtrim((string) config('keyvault.endpoint'), '/');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$endpoint}/secrets/{$secretName}", [
                'api-version' => '7.4',
            ]);

            if ($response->failed()) {
                throw new \RuntimeException("Failed to get Key Vault secret '{$secretName}': " . $response->body());
            }

            return (string) $response->json('value');
        });
    }

    public function setSecret(string $secretName, string $value): void
    {
        Cache::forget("keyvault_secret_{$secretName}");

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
            throw new \RuntimeException("Failed to update Key Vault secret '{$secretName}': " . $response->body());
        }
    }
}

