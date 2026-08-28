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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gtm' => [
        'container_id' => env('GTM_CONTAINER_ID'),
    ],

    'turnstile' => [
        // Laisser vide désactive complètement l'intégration (widget non affiché,
        // vérification serveur ignorée) — même convention que gtm.container_id.
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

    'ga4' => [
        'property_id' => env('GA4_PROPERTY_ID'),
        'credentials_path' => env('GA4_CREDENTIALS_PATH'),
        // Rempli à l'exécution depuis la table `settings` si configuré via l'admin
        // (voir AppServiceProvider::applyDatabaseSettings) ; prioritaire sur credentials_path.
        'credentials_json' => null,
    ],

];
