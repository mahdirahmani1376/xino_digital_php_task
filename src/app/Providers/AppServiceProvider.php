<?php

namespace App\Providers;

use App\Integrations\Payment\PaymentSystemInterface;
use App\Integrations\Payment\PaypalPaymentProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(PaymentSystemInterface::class, PaypalPaymentProvider::class);
    }
}
