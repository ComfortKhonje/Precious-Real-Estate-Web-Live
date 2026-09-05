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

    // GA4 Measurement ID (looks like "G-XXXXXXXXXX"). Paid for in the
    // original hosting proposal ("Analytics & Reporting" line item,
    // MWK 65,000) but never actually added to the site — confirmed
    // 2026-09-02, no tracking snippet existed anywhere. Set
    // GOOGLE_ANALYTICS_ID in .env once a real GA4 property exists; the
    // layout only renders the gtag snippet when this is non-empty, so it's
    // a safe no-op until then.
    'google_analytics_id' => env('GOOGLE_ANALYTICS_ID'),

];
