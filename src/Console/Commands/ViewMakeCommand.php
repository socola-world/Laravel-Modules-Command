<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;

class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
    use GeneratorCommand;

    protected function getPath($name)
    {
        return OpenPhpstorm::add(parent::getPath($name));
    }
}
