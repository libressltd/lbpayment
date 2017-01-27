<?php

namespace LIBRESSLtd\LBMessenger;

use Illuminate\Support\ServiceProvider;
use Form;

class LBMessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/libressltd/lbmessenger'),
            __DIR__.'/models' => base_path('app/Models'),
            __DIR__.'/migrations' => base_path('database/migrations'),
        ], "lbmessenger");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('LIBRESSLtd\LBMessenger\Controllers\LBM_conversationController');
        $this->app->make('LIBRESSLtd\LBMessenger\Controllers\LBM_conversationItemController');
        $this->app->make('LIBRESSLtd\LBMessenger\Controllers\Ajax\LBM_conversationController');
        $this->app->make('LIBRESSLtd\LBMessenger\Controllers\Ajax\LBM_conversationItemController');
    }
}
