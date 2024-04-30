<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use Symfony\Component\Filesystem\Path;

trait BaseCommand
{
    use CommonCommand;

    protected function getMigrationPaths()
    {
        return [$this->getMigrationPath()];
    }

    protected function getMigrationPath()
    {
        $module = $this->getModule();

        return Path::join($module->getPath(), config('modules.paths.generator.migration.path'));
    }
}
