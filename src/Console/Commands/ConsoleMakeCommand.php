<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;

class ConsoleMakeCommand extends \Illuminate\Foundation\Console\ConsoleMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $code = parent::buildClass($name);

        $replaces = [
            'use Illuminate\Console\Command;' => 'use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;',
        ];

        return str_replace(array_keys($replaces), array_values($replaces), $code);
    }
}
