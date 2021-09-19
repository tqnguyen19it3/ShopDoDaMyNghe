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

    'facebook' => [
        'client_id' => '2763403467285041',
        'client_secret' => 'd9fef9f901c939d07958a72cd01fed7e',  
        'redirect' => 'http://localhost:2509/ShopDoDaMyNghe/login/callback'
    ],

    'google' => [
        'client_id' => '844113457663-o09p9v40h3424f6u7gggtj348a27afgl.apps.googleusercontent.com',
        'client_secret' => 'w2EqMdygF8z1qyfhIUo0EQA6',
        // 'redirect' => 'http://nvsportsfootball.com:2509/ShopDoDaMyNghe/google/callback'
        'redirect' => 'http://localhost:2509/ShopDoDaMyNghe/google/callback'
    ],

];
