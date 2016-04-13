<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
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

    'google' => [ // LEFT HERE
        'model' => App\User::class,
        'client_id' => '1077076536051-081ecmj6nih6gmi634sn8frkuvlhvhju.apps.googleusercontent.com',
        'client_secret' => 'MLLJcFu06p6gcK26xflWpfQ3',
//         'redirect' => 'http://gamenight.app/oauth_callback'
        'redirect' => env('GOOGLE_CALLBACK')
    ],

];
