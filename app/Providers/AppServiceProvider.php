<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\BillingTest\BankPayment;
use App\BillingTest\CreditPayment;
use App\BillingTest\PaymentContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleTon(PaymentContract::class, function($app) {
            if(request()->has('credit')) {
                return new CreditPayment('usd');
            }
            return new BankPayment('usd');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
