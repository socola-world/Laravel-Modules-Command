<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;

class FindMissingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:find-missing-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find missing command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get List command
        $commands = Artisan::all();
        $commandNames = array_keys($commands);
        $laravelCommandNames = collect($commandNames)
            ->filter(function ($commandName) {
                return
                        Str::startsWith($commandName, [
                            'db:',
                        ])

                    || (
                        !Str::startsWith($commandName, [
                            'cms:',
                            'sail:',
                        ])
                        && !in_array($commandName, [
                            'db:monitor',
                            'serve',
                            'session:table',
                            'make:session-table',
                            'migrate:install',
                            'make:queue-table',
                            'queue:table',
                            'queue:batches-table',
                            'make:queue-batches-table',
                            'queue:failed-table',
                            'make:notifications-table',
                            'make:queue-failed-table',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                        ])
                    );
            })
            ->all()
        ;
        $cmsCommandNames = collect($commandNames)
            ->filter(function ($commandName) {
                return Str::startsWith($commandName, 'cms:');
            })
            ->all()
        ;
        $missingCommandNames = collect($laravelCommandNames)
            ->filter(function ($laravelCommandName) use ($cmsCommandNames) {
                return !in_array("cms:{$laravelCommandName}", $cmsCommandNames);
            })
            ->all()
        ;
        $this->line('Missing Command:'. json_encode($missingCommandNames, JSON_PRETTY_PRINT));
        // dd(
        //     'Laravel Command Names',
        //     $laravelCommandNames,
        //     'CMS Command Names',
        //     $cmsCommandNames
        // );
    }
}
