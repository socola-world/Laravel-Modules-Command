<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Contracts\Events\Dispatcher;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\BaseCommand;

class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{
    use BaseCommand;

    public function __construct(
        Dispatcher $dispatcher,
    ) {
        $this->signature = str_replace('migrate', 'cms:migrate {module}', $this->signature);
        $migrator = app('migrator');

        parent::__construct($migrator, $dispatcher);
    }
}
