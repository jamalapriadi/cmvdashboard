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

    /* Social Media */
    'facebook' => [
        'client_id'     => env('FB_ID'), //330369550842883
        'client_secret' => env('FB_SECRET'), //ec82b95bd572837b38b2f1525e04970f
        'redirect'      => env('FB_URL'), //https://sm.mncgroup.local/intra-sm/sosmed/sosmed/connect/facebook/callback
    ],
    'twitter' => [
        'client_id'     => env('TWITTER_ID'), //VlsK3OmrR8RI5H3gxLiDaa5vY
        'client_secret' => env('TWITTER_SECRET'), //BMjg7RwIMzzZXzdzPHl2r6Sj1qb8M5uLBvAdeRVrsMoXna9kFN
        'redirect'      => env('TWITTER_URL'), //https://sm.mncgroup.local/intra-sm/sosmed/sosmed/connect/twitter/callback
    ],
    'google' => [
        'client_id'     => env('GOOGLE_ID'), //557264382946-eerhgf8edmmot5jp3nd06vgicdr9cgmi.apps.googleusercontent.com
        'client_secret' => env('GOOGLE_SECRET'), //yu54zFyWL2_HwwcnRWqHDHHN
        'redirect'      => env('GOOGLE_URL'), //https://sm.mncgroup.local/intra-sm/sosmed/sosmed/connect/google/callback
    ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI')
    ],

];
