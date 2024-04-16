<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Support\ServiceProvider;
use SocolaDaiCa\LaravelModulesCommand\Console\Kernel as ConsoleKernel;
use SocolaDaiCa\LaravelModulesCommand\OpenPhpstorm;

class LaravelModulesCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-modules-command.php', 'laravel-modules-command');

        // $this->app->register(\Nwidart\Modules\LaravelModulesServiceProvider::class);
        $this->app->register(OverwriteLaravelModulesServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Boot the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->app->singleton(ConsoleKernel::class);
            $this->app->make(ConsoleKernel::class);
        }

        $this->app->singleton(OpenPhpstorm::class);
    }
}
