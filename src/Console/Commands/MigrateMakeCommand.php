<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use SocolaDaiCa\LaravelBadassium\Illuminate\Database\Console\Migrations\TableGuesser;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\BaseCommand;

class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use BaseCommand;

    /**
     * Create a new migration install command instance.
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        $this->signature = str_replace('make:migration', 'cms:make:migration {module}', $this->signature);

        parent::__construct($creator, $composer);
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->getGeneratorFolder('migration');
    }

    protected function writeMigration($name, $table, $create)
    {
        if (!$table) {
            [$table, $create] = TableGuesser::guess($name);
        }

        parent::writeMigration($name, $table, $create);
    }
}
