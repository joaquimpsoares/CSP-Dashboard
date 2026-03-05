<?php

return [
    'endpoint'      => env('KEY_VAULT_ENDPOINT', 'https://tagydes-vault.vault.azure.net/'),
    'client_id'     => env('KEY_VAULT_CLIENT_ID'),
    'client_secret' => env('KEY_VAULT_CLIENT_SECRET'),
    'tenant_id'     => env('KEY_VAULT_TENANT_ID'),
];
