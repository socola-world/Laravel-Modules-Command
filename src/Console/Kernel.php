<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console;

use Illuminate\Console\Scheduling\Schedule;
use ReflectionException;

class Kernel extends \SocolaDaiCa\LaravelBadassium\Contracts\Console\Kernel
{
    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Migrations\RefreshCommand::class,
        Commands\Migrations\ResetCommand::class,
        Commands\Migrations\FreshCommand::class,
        Commands\CastMakeCommand::class,
        Commands\ChannelMakeCommand::class,
        Commands\ComponentMakeCommand::class,
        Commands\ConsoleMakeCommand::class,
        Commands\ControllerMakeCommand::class,
        Commands\ClassMakeCommand::class,
        Commands\EventMakeCommand::class,
        Commands\ExceptionMakeCommand::class,
        Commands\FactoryMakeCommand::class,
        Commands\JobMakeCommand::class,
        Commands\ListenerMakeCommand::class,
        Commands\MailMakeCommand::class,
        Commands\MiddlewareMakeCommand::class,
        Commands\Migrations\StatusCommand::class,
        Commands\MigrateMakeCommand::class,
        Commands\ModuleMakeCommand::class,
        Commands\NotificationMakeCommand::class,
        Commands\ObserverMakeCommand::class,
        Commands\PolicyMakeCommand::class,
        Commands\ProviderMakeCommand::class,
        Commands\RequestMakeCommand::class,
        Commands\ResourceMakeCommand::class,
        Commands\RuleMakeCommand::class,
        // SeedCommand::class,
        Commands\SeederMakeCommand::class,
        Commands\TestMakeCommand::class,
        Commands\ViewMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\RollbackCommand::class,
        /* new */
        Commands\CmsCommand::class,
        Commands\Customs\FacadeDocsCommand::class,
        Commands\FacadeMakeCommand::class,
        Commands\HttpKernelMakeCommand::class,
        Commands\IdeHelperCommnad::class,
        Commands\ModuleLinkCommand::class,
        Commands\ModuleUpdateCommand::class,
        Commands\ProviderMake1Command::class,
        Commands\StorageLinkCommand::class,
        Commands\StorageUnlinkCommand::class,
        /**/
        Commands\ModelMakeCommand::class,
        /* Customs */
        Commands\Customs\VendorLinkCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @throws ReflectionException
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');
        require_once __DIR__.'/../../routes/console.php';
    }
}
