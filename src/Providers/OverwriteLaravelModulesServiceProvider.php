<?php

namespace SocolaDaiCa\LaravelModulesCommand\Providers;

use Illuminate\Database\Migrations\MigrationCreator;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\LaravelModulesServiceProvider;
use SocolaDaiCa\LaravelModulesCommand\Helper;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\LaravelFileRepository;

class OverwriteLaravelModulesServiceProvider extends LaravelModulesServiceProvider
{
    public function register()
    {
        Helper::overwrireModulesConfig();
        parent::register();
        // $this->mergeConfigFrom(base_path('vendor/nwidart/laravel-modules/config/config.php'), 'modules');

        $this->app->singleton(RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new LaravelFileRepository($app, $path);
        });

        $this->app->singleton(MigrationCreator::class, function ($app) {
            return new \SocolaDaiCa\LaravelModulesCommand\Overwrite\MigrationCreator(
                $app['files'],
                $app->basePath('stubs'),
            );
        });
    }

    /**
     * Boot the application events.
     */
    public function boot()
    {
        parent::boot();
        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            })
        ;
    }
}
