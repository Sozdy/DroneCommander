<?php

namespace App\Providers;

use App\Services\Drone\DroneService;
use App\Services\Drone\IDroneService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!$this->app->isProduction());
    }

    private function bindServices(): void
    {
        $this->app->singleton(
            IDroneService::class,
            DroneService::class
        );
    }
}
