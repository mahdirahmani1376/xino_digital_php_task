<?php

return [
    'paypal' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SANDBOX_SECRET'),
        'base_url' => env('PAYPAL_BASE_URL'),
    ],
];
