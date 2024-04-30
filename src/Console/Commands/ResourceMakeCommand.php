<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\StubModify;
use Symfony\Component\Console\Input\InputOption;

class ResourceMakeCommand extends \Illuminate\Foundation\Console\ResourceMakeCommand
{
    use GeneratorCommand;

    protected function getOptions()
    {
        $options = parent::getOptions();

        $options[] = ['model', 'm', InputOption::VALUE_REQUIRED, 'Generate a resource for the given model'];

        return $options;
    }

    protected function buildClass($name)
    {
        $code = parent::buildClass($name);

        /** @var StubModify $stubModify */
        $stubModify = app(StubModify::class);

        return $stubModify->resource(
            $code,
            $this->option('model')
        );
    }
}
