<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => 'your-github-app-id',
        'client_secret' => 'your-github-app-secret',
        'redirect' => 'http://mdl.dev/auth/github/callback',
    ],

    'facebook' => [
        'client_id' => '1510886492549477',
        'client_secret' => '41f683bc22a73c172510e541134e3d87',
        'redirect' => 'http://mdl.dev/auth/facebook/callback',
    ],

    'gmail' => [
        'client_id' => '351246343118-ijvcjo42qkot0hae1fsrmp0kf0661uft.apps.googleusercontent.com',
        'client_secret' => '2rdk-kJb55uaFTtRRSid98Nr',
        'redirect' => 'http://mdl.dev/auth/gmail/callback',
    ],

];
