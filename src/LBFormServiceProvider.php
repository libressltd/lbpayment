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
        $this->loadViewsFrom(__DIR__.'/views', 'lbform');
		$this->publishes([
	        __DIR__.'/views' => base_path('resources/views/layouts/form'),
	        __DIR__.'/config' => base_path('config'),
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
