<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;

class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        return parent::buildClass($name);
    }
}
