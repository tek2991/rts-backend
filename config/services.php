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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'instamojo' => [
        'client_id' => env('INSTAMOJO_CLIENT_ID'),
        'client_secret' => env('INSTAMOJO_CLIENT_SECRET'),
        'private_salt' => env('INSTAMOJO_PRIVATE_SALT'),
        'sandbox' => env('INSTAMOJO_SANDBOX', true), // False if you are using live account
        'auth_type' => env('INSTAMOJO_AUTH_TYPE', 'app'), // 'app' or 'user'
        'enable_webhook' => env('INSTAMOJO_ENABLE_WEBHOOK', true), // False if you don't want to verify webhook call
    ],

    'textlocal' => [
        'api_key' => env('TEXTLOCAL_API_KEY'),
        'sender' => env('TEXTLOCAL_SENDER'),
        'test_mode' => env('TEXTLOCAL_TEST_MODE', true), // False if you are using live account
        'send_sms_url' => env('TEXTLOCAL_SEND_SMS_URL', 'https://api.textlocal.in/send/'),
    ],

    'apk' => [
        'url' => env('APK_URL'),
    ],

    'phonepe' => [
        'merchant_id' => env('PHONEPE_MERCHANT_ID'),
        'salt' => env('PHONEPE_SALT'),
        'salt_index' => env('PHONEPE_SALT_INDEX'),
        'preprod_url' => env('PHONEPE_PREPROD_URL'),
        'prod_url' => env('PHONEPE_PROD_URL'),
        'pay_endpoint' => env('PHONEPE_PAY_ENDPOINT'),
        'status_endpoint' => env('PHONEPE_STATUS_ENDPOINT'),
        'production' => env('PHONEPE_PRODUCTION', false),
    ],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
        'hosted_url' => env('RAZORPAY_HOSTED_URL'),
    ],

    'payment_gateway' => [
        'default' => env('PAYMENT_GATEWAY', 'instamojo'), // 'instamojo' or 'phonepe' or 'razorpay'
    ],
];
