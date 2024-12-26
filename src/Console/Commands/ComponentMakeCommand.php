<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;

class ComponentMakeCommand extends \Illuminate\Foundation\Console\ComponentMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $alias = $this->getModule()->get('alias');

        return str_replace(
            'view(\'components.',
            "view('{$alias}::components.",
            parent::buildClass($name),
        );
    }
}
