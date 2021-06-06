<?php

namespace App\Providers;

use App\Providers\ServiceProvider\LocalServiceProvider;
use App\Providers\ServiceProvider\ProductionServiceProvider;
use App\Providers\ServiceProvider\Provider;
use App\Providers\ServiceProvider\StagingServiceProvider;
use App\Providers\ServiceProvider\TestServiceProvider;
use Illuminate\Support\ServiceProvider;
use OutOfBoundsException;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $provider = $this->provider();
        $provider->register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $provider = $this->provider();
        $provider->boot();
    }

    /**
     * @return \App\Providers\ServiceProvider\Provider
     */
    private function provider(): Provider
    {
        $env = config('app.env');
        return match ($env) {
            'testing' => new TestServiceProvider($this->app),
            'local' => new LocalServiceProvider($this->app),
            'staging' => new StagingServiceProvider($this->app),
            'production' => new ProductionServiceProvider($this->app),
            default => throw new OutOfBoundsException(),
        };
    }
}
