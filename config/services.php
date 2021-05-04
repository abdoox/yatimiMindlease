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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
	'mailjet' => [
        "username" => "085978f38c86c0438bb680a7b6aff6fb",
        "secret" => "cca9e9875298d428f20c91cf2362777b"
    ]
    //'mailjet' => [
    //'key' => env('MAILJET_APIKEY'),
    //'secret' => env('MAILJET_APISECRET'),
//]
/*'facebook' => [
     'client_id' => '382239952690593',
     'client_secret' => '6d3922ae465ca3541a0d441c4249afe6',
    // 'redirect' => 'https://www.tutsmake.com/laravel-example/callback/facebook',
   ],
'google' => [
    'client_id'     => ,
    'client_secret' => ,
    'redirect'      => */

];
