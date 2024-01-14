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
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'sms'      => [
        'unifonic' => [
            'app_id'  => env('SMS_AppSid'),
            'url'     => env('SMS_URL'),
            'balance' => env('SMS_BALANCE_URL'),
            'url_wrapper' => env('SMS_URL_WRAPPER'),
            'user_id'     => env('SMS_USER_ID'),
            'password'    => env('SMS_PASSWORD'),
            'sender_id'   => env('SMS_SENDER_ID'),
        ],
    ],
    'aramex'  => [
        'username' => env('ARAMEX_USERNAME'),
        'password' => env('ARAMEX_PASSWORD'),
        'account_number' => env('ARAMEX_ACCOUNT_NUMBER'),
        'account_pin' => env('ARAMEX_ACCOUNT_PIN'),
        'account_entity' => env('ARAMEX_ACCOUNT_ENTITY'),
        'account_country_code' => env('ARAMEX_ACCOUNT_COUNTRY_CODE'),
        'account_person_name' => env('ARAMEX_ACCOUNT_PERSON_NAME'),
        'account_company_name' => env('ARAMEX_ACCOUNT_COMPANY_NAME'),
        'account_phone_number' => env('ARAMEX_ACCOUNT_PHONE_NUMBER'),
        'account_email' => env('ARAMEX_ACCOUNT_EMAIL'),
        'city' => env('ARAMEX_CITY'),
        'address_line1' => env('ARAMEX_ADDRESS_LINE1'),
        'calculate_rate_endpoint' => env('ARAMEX_CALCULATE_RATE_ENDPOINT'),
        'create_shipments_endpoint' => env('ARAMEX_CREATE_SHIPMENTS_ENDPOINT'),
        'print_label_endpoint' => env('ARAMEX_PRINT_LABEL_ENDPOINT'),
        'track_shipment_endpoint' => env('ARAMEX_TRACK_SHIPMENTS_ENDPOINT'),
    ],
    'payments' => [
        'paytabs' => [
            'merchant_email'     => env('PAYTABS_EMAIL'),
            'merchant_id'        => env('PAYTABS_ID'),
            'verify_payment'     => env('PAYTABS_VERIFY_PAYMENT_URL'),
            'verify_api_payment' => env('PAYTABS_VERIFY_API_PAYMENT_URL'),
            'secret_key'         => env('PAYTABS_SECRET_KEY'),
            'return_url'         => env('APP_URL') . '/paytabs/status',
        ]
    ],
    'moyasar' => [
        'publishable_api_key' => env('PUBLISHABLE_API_KEY'),
        'secret_api_key' => env('SECRET_API_KEY')
    ]

];
