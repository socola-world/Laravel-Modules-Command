<?php

namespace __MODULE_NAMESPACE__\__STUDLY_NAME__\Providers;

use __MODULE_NAMESPACE__\__STUDLY_NAME__\Console\Kernel as ConsoleKernel;
use __MODULE_NAMESPACE__\__STUDLY_NAME__\Exceptions\Handler as ExceptionsHandler;
use __MODULE_NAMESPACE__\__STUDLY_NAME__\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class __STUDLY_NAME__ServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        app(ExceptionsHandler::class);

        $this->app->register(BroadcastServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HttpKernel::class);
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->registerAssets();
        $this->registerMigrations();
        $this->app->singleton(ConsoleKernel::class);
        $this->app->make(ConsoleKernel::class);

        foreach (config('__LOWER_NAME__.alias', []) as $alias => $class) {
            $this->app->alias($class, $alias);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../../__PATH_CONFIG__/__LOWER_NAME__.php', '__LOWER_NAME__');

        $this->publishes([
            __DIR__.'/../../__PATH_CONFIG__/__LOWER_NAME__.php' => config_path('__LOWER_NAME__.php'),
        ], 'config');
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../../__PATH_VIEWS__', '__LOWER_NAME__');

        $this->publishes([
            __DIR__.'/../../__PATH_VIEWS__' => resource_path('views/vendor/__LOWER_NAME__'),
        ], 'views');

        Blade::componentNamespace('__MODULE_NAMESPACE__\__STUDLY_NAME__\View\Components', '__LOWER_NAME__');
    }

    /**
     * Register assets.
     *
     * @return void
     */
    public function registerAssets()
    {
        $this->publishes([
            __DIR__.'/../../public/vendor/__VENDOR__/__LOWER_NAME__' => public_path('vendor/__VENDOR__/__LOWER_NAME__'),
        ], 'laravel-assets');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../__PATH_LANG__', '__LOWER_NAME__');

        $this->publishes([
            __DIR__.'/../../__PATH_LANG__' => lang_path('vendor/__LOWER_NAME__'),
        ], 'lang');
    }

    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../__PATH_MIGRATIONS__');

        $this->publishes([
            __DIR__.'/../../__PATH_MIGRATIONS__' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
