<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'facebook' => [
        'client_id' => '215683386339786',
        'client_secret' => '72e43ffc094444a96c0a72a634cf5733',
        'redirect' => 'http://idojarasapi.szakdolgozat.net/auth/facebook/callback',
    ],
 'google' => [
        'client_id' => '552530611138-muc3177kln0ddv6etusf83kohaauejc1.apps.googleusercontent.com',
        'client_secret' => '8oR6PlHujLOyPGhuykdk9auA',
        'redirect' => 'http://idojarasapi.szakdolgozat.net/auth/google/callback',
    ],

];
