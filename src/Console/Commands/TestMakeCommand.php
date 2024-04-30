<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;

class TestMakeCommand extends \Illuminate\Foundation\Console\TestMakeCommand
{
    use GeneratorCommand;

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('unit')) {
            return $this->getGeneratorNamespace('test');
        }

        return $this->getGeneratorNamespace('test-feature');
    }
}
