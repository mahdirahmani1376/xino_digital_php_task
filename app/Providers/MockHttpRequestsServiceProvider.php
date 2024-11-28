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
            'https://api.sandbox.paypal.com/v1/payments/payment/execute' => Http::response([
                'id' => 'PAYID-MOCK123456789',
                'state' => 'approved',
            ], 200),
        ]);
    }
}
