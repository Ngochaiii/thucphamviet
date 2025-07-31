<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for the application
    |
    */
    'default' => env('DEFAULT_CURRENCY', 'JPY'),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | List of currencies supported by the application
    |
    */
    'supported' => [
        'JPY', 'VND', 'USD', 'EUR', 'CNY', 'KRW'
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Display Order
    |--------------------------------------------------------------------------
    |
    | Order of currencies in dropdown (most used first)
    |
    */
    'display_order' => [
        'JPY', 'VND', 'USD', 'EUR', 'CNY', 'KRW'
    ],

    /*
    |--------------------------------------------------------------------------
    | Exchange Rate API
    |--------------------------------------------------------------------------
    |
    | Configuration for exchange rate API
    |
    */
    'exchange_api' => [
        'provider' => env('EXCHANGE_RATE_PROVIDER', 'fixer'), // fixer, exchangerate-api, etc.
        'api_key' => env('EXCHANGE_RATE_API_KEY'),
        'base_currency' => 'JPY',
        'cache_duration' => 3600, // seconds
    ],
];
