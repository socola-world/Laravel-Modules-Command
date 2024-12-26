<?php

use Nwidart\Modules\Activators\FileActivator;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CastMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ChannelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\CmsCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ComponentMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ConsoleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ControllerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\EventMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ExceptionMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FacadeMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\FactoryMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\HttpKernelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\IdeHelperCommnad;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\JobMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ListenerMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MailMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MiddlewareMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\MigrateMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModelMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModuleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ModuleUpdateCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\NotificationMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ObserverMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\PolicyMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ProviderMake1Command;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ProviderMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RequestMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ResourceMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\RuleMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\SeederMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\StorageLinkCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\TestMakeCommand;
use SocolaDaiCa\LaravelModulesCommand\Console\Commands\ViewMakeCommand;

return [
    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path('vendor/socoladaica/laravel-modules-command/stubs'),
        'files' => $files = [
            // // 'views/index' => 'resources/views/index.blade.php',
            // 'views/master' => 'resources/views/layouts/master.blade.php',
            // 'scaffold/config' => 'config/config.php',
            // /**/
            // /**/
            /* Folder */
            '.github/workflows/php-cs-fixer.yml' => '.github/workflows/php-cs-fixer.yml',
            '.github/workflows/review-code.yml' => '.github/workflows/review-code.yml',
            '.github/workflows/release.yml' => '.github/workflows/release.yml',
            '.github/dependabot.yml' => '.github/dependabot.yml',
            'config/config.php' => 'config/__LOWER_NAME__.php',
            'public/.gitkeep' => 'public/vendor/__VENDOR__/__LOWER_NAME__/.gitkeep',
            'resources/assets/js/app.js' => 'resources/assets/js/app.js',
            'resources/assets/sass/app.scss' => 'resources/assets/sass/app.scss',
            'resources/assets/img/.gitkeep' => 'resources/assets/img/.gitkeep',
            'resources/views/pages/.gitkeep' => 'resources/views/pages/.gitkeep',
            'routes/api.php' => 'routes/api.php',
            'routes/channels.php' => 'routes/channels.php',
            'routes/console.php' => 'routes/console.php',
            'routes/web.php' => 'routes/web.php',
            'src/Console/Kernel.php' => 'src/Console/Kernel.php',
            'src/Exceptions/Handler.php' => 'src/Exceptions/Handler.php',
            'src/Http/Controllers/Controller.php' => 'src/Http/Controllers/Controller.php',
            'src/Http/Kernel.php' => 'src/Http/Kernel.php',
            'src/Providers/AppServiceProvider.php' => 'src/Providers/__STUDLY_NAME__ServiceProvider.php',
            'src/Providers/BroadcastServiceProvider.php' => 'src/Providers/BroadcastServiceProvider.php',
            'src/Providers/EventServiceProvider.php' => 'src/Providers/EventServiceProvider.php',
            'src/Providers/RouteServiceProvider.php' => 'src/Providers/RouteServiceProvider.php',
            /* File */
            '.editorconfig.stub' => '.editorconfig',
            '.gitattributes.stub' => '.gitattributes',
            '.gitignore.stub' => '.gitignore',
            'composer.json' => 'composer.json',

            'LICENSE/'.config('laravel-modules-command.composer.license') => 'LICENSE',
            'package.json' => 'package.json',
            'phpunit.xml.stub' => 'phpunit.xml',
            'README.md' => 'README.md',
            'webpack.mix.js' => 'webpack.mix.js',
        ],
        'force_overwire' => [
            '.github/workflows/php-cs-fixer.yml',
            '.github/workflows/review-code.yml',
            '.github/workflows/release.yml',
            '.github/dependabot.yml',
            '.gitattributes.stub',
            '.gitignore.stub',
        ],
        'replacements' => array_merge(
            [
                'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            ],
            array_map(fn ($item) => [
                'AUTHOR_EMAIL',
                'AUTHOR_NAME',
                'AUTHOR_ROLE',
                'AUTHOR_HOMEPAGE',
                'PHP',
                'LOWER_NAME',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                'STUDLY_NAME',
                'VENDOR',
                'YEAR',
                'LICENSE',
                'PATH_CONFIG',
                'PATH_VIEWS',
                'PATH_LANG',
                'PATH_MIGRATIONS',
            ], $files),
        ),
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('Modules'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config' => ['path' => 'config', 'generate' => false],
            'command' => ['namespace' => 'Console/Commands', 'path' => 'src/Console/Commands', 'generate' => false],
            'cast' => ['namespace' => 'Casts', 'path' => 'src/Casts', 'generate' => false],
            'migration' => ['namespace' => 'Database/Migrations', 'path' => 'database/migrations', 'generate' => true],
            'facade' => ['namespace' => 'Facades', 'path' => 'src/Facades', 'generate' => false],
            'seeder' => ['namespace' => 'Database/Seeders', 'path' => 'database/seeders', 'generate' => false],
            'factory' => ['namespace' => 'Database/Factories', 'path' => 'database/factories', 'generate' => true],
            'model' => ['namespace' => 'Models', 'path' => 'src/Models', 'generate' => false],
            'routes' => ['path' => 'routes', 'generate' => false],
            'controller' => ['namespace' => 'Http/Controllers', 'path' => 'src/Http/Controllers', 'generate' => false],
            // 'filter' => ['namespace' => 'Http/Middleware', 'path' => 'src/Http/Middleware', 'generate' => false],
            'middleware' => ['namespace' => 'Http/Middleware', 'path' => 'src/Http/Middleware', 'generate' => false],
            'request' => ['namespace' => 'Http/Requests', 'path' => 'src/Http/Requests', 'generate' => false],
            'provider' => ['namespace' => 'Providers', 'path' => 'src/Providers', 'generate' => false],
            'assets' => ['path' => 'resources/assets', 'generate' => true],
            'lang' => ['path' => 'resources/lang', 'generate' => true],
            'views' => ['path' => 'resources/views', 'generate' => true],
            'view' => ['path' => 'resources/views', 'generate' => true],
            'test' => ['namespace' => 'Tests/Unit', 'path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['namespace' => 'Tests/Feature', 'path' => 'tests/Feature', 'generate' => true],
            'repository' => ['namespace' => 'Repositories', 'path' => 'src/Repositories', 'generate' => false],
            'event' => ['namespace' => 'Events', 'path' => 'src/Events', 'generate' => false],
            'listener' => ['namespace' => 'Listeners', 'path' => 'src/Listeners', 'generate' => false],
            'policies' => ['namespace' => 'Policies', 'path' => 'src/Policies', 'generate' => false],
            'policy' => ['namespace' => 'Policies', 'path' => 'src/Policies', 'generate' => false],
            'rules' => ['namespace' => 'Rules', 'path' => 'src/Rules', 'generate' => false],
            'rule' => ['namespace' => 'Rules', 'path' => 'src/Rules', 'generate' => false],
            'jobs' => ['namespace' => 'Jobs', 'path' => 'src/Jobs', 'generate' => false],
            'job' => ['namespace' => 'Jobs', 'path' => 'src/Jobs', 'generate' => false],
            'emails' => ['namespace' => 'Mail', 'path' => 'src/Mail', 'generate' => false],
            'mailable' => ['namespace' => 'Mail', 'path' => 'src/Mail', 'generate' => false],
            'exception' => ['namespace' => 'Exceptions', 'path' => 'src/Exceptions', 'generate' => false],
            'notifications' => ['namespace' => 'Notifications', 'path' => 'src/Notifications', 'generate' => false],
            'notification' => ['namespace' => 'Notifications', 'path' => 'src/Notifications', 'generate' => false],
            'resource' => ['namespace' => 'Resources', 'path' => 'src/Resources', 'generate' => false],
            'component-view' => ['path' => 'resources/views/components', 'generate' => false],
            'component-class' => ['namespace' => 'View/Components', 'path' => 'src/View/Components', 'generate' => false],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    'commands' => [
        /* custom */
        CastMakeCommand::class,
        ChannelMakeCommand::class,
        ComponentMakeCommand::class,
        ConsoleMakeCommand::class,
        ControllerMakeCommand::class,
        EventMakeCommand::class,
        ExceptionMakeCommand::class,
        FactoryMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        // Migrations\StatusCommand::class,
        MigrateMakeCommand::class,
        ModuleMakeCommand::class,
        NotificationMakeCommand::class,
        ObserverMakeCommand::class,
        PolicyMakeCommand::class,
        ProviderMakeCommand::class,
        RequestMakeCommand::class,
        ResourceMakeCommand::class,
        RuleMakeCommand::class,
        // SeedCommand::class,
        SeederMakeCommand::class,
        TestMakeCommand::class,
        ViewMakeCommand::class,
        SocolaDaiCa\LaravelModulesCommand\Console\Commands\MigrateCommand::class,
        SocolaDaiCa\LaravelModulesCommand\Console\Commands\RollbackCommand::class,
        /* new */
        HttpKernelMakeCommand::class,
        ProviderMake1Command::class,
        StorageLinkCommand::class,
        SocolaDaiCa\LaravelModulesCommand\Console\Commands\StorageUnlinkCommand::class,
        CmsCommand::class,
        IdeHelperCommnad::class,
        ModuleUpdateCommand::class,
        FacadeMakeCommand::class,
        SocolaDaiCa\LaravelModulesCommand\Console\Commands\Customs\FacadeDocsCommand::class,
        /**/
        ModelMakeCommand::class,
        /* Customs */
        SocolaDaiCa\LaravelModulesCommand\Console\Commands\Customs\VendorLinkCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        // 'enabled' => true,
        // 'paths' => [
        //     base_path('vendor/*/*'),
        // ],

        'enabled' => true,
        'paths' => [
            base_path('vendor/*/*'),
            base_path('Modules/*'),
            base_path('Modules/*/*'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        // 'enabled' => false && app()->runningInConsole() == false,
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 0,

        // 'enabled' => true,
        // 'lifetime' => 60000,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method.
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604_800,
            // 'cache-lifetime' => 0,
        ],
    ],

    'activator' => 'file',
];
