<?php

return [

    'name' => 'MicrosoftCspConnection',

    /*
    |--------------------------------------------------------------------------
    | Global Defaults (no per-tenant credentials here)
    |--------------------------------------------------------------------------
    | Per-provider credentials are stored in the microsoft_csp_connections table.
    | These are global URL defaults only.
    */

    'api_url'                => env('CSP_API_URL', 'https://api.partnercenter.microsoft.com'),

    'auth_url'               => 'https://login.microsoftonline.com',

    'partner_center_resource' => 'https://api.partnercenter.microsoft.com',

    'graph_resource'         => 'https://graph.microsoft.com',

];
