<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class MockHttpRequestsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (app()->environment("local")) {
            $this->mockHttpRequests();
        }
    }

    private function mockHttpRequests(): void
    {
        Http::fake([
            config('payment.paypal.base_url') .'/execute' => Http::response([
                'paymentId' => 'PAYID-MOCK123456789',
                'state' => 'approved',
            ], 200),
            config('payment.paypal.base_url') .'/v1/billing/plans' => Http::response([
                'state' => 'success',
            ], 200),
            config('payment.paypal.base_url') .'/v1/payments/payment' => Http::response([
                'paymentId' => 'PAYID-MOCK123456789',
            ], 200),
            config('payment.paypal.base_url') .'/v1/oauth2/token' => Http::response([
                'access_token' => 'test',
            ], 200),
        ]);
    }
}
