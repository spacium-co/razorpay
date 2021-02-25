<?php

namespace Spaciumco\Razorpay\Providers;

use Illuminate\Support\ServiceProvider;
use Razorpay\Api\Api;

/**
 * The Razorpay Serviceprovider
 *
 * Razorpay - ServicePrivider to support integration with 
 * Laravel framework
 *
 * @author     Spacium-co <Spacium-co@gmail.com>
 *             <contributor name> <contributor@your.email>
 * @package    Razorpay
 * @version    1.0.0
 * @since      Class available since Release 1.0.0
 */
class RazorpayServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'../config/razorpay.php' => config_path('razorpay.php')
        ], 'razorpay');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'../config/razorpay.php', 'razorpay');


        if (method_exists(\Illuminate\Foundation\Application::class, 'singleton')) {
            $this->app->singleton('Razorpay\Api\Api', function($app) {
                $key = env('RAZORPAY_KEY_ID');
                $secret = env('RAZORPAY_KEY_SECRET');
                return new Api($key, $secret);
            });
        } else {
            $this->app['razorpay'] = $this->app->share(function($app) {
                $config = $app->make('config');
                $key = env('RAZORPAY_KEY_ID');
                $secret = env('RAZORPAY_KEY_SECRET');
                return new Api($key, $secret);
            });
        }

    }

}
// end of RazorpayServiceProvider class
// end of file RazorpayServiceProvider.php
