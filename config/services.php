<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ms-teams' => [
        'webhook_url' => env('MS_TEAMS_WEBHOOK_URL', 'https://outlook.office.com/webhook/559e722e-716e-4923-b355-c9c6b279c4d0@8ca67df0-0e63-4a05-845d-1067cfccd79d/IncomingWebhook/816bba4df7214300b5a9ede4848fc304/22047d5e-9982-4c68-8a67-f95654e761b8')
    ],

];
