<?php

namespace LIBRESSLtd\LBPayment;

use Illuminate\Support\ServiceProvider;
use Form;

class LBPaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->publishes([
            __DIR__.'/models' => base_path('app/Models'),
            __DIR__.'/migrations' => base_path('database/migrations'),
	    ], "lbpayment");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('LIBRESSLtd\LBPayment\Controllers\LBPCoinPaymentController');
    }
}
