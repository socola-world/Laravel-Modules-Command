<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands\Customs;

use Symfony\Component\Console\Input\InputArgument;

class FacadeMakeCommand extends \Illuminate\Console\GeneratorCommand
{
    protected $name = 'make:facade';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Facade';

    protected function getStub()
    {
        return base_path('vendor/laravel/framework/src/Illuminate/Foundation/stubs/facade.stub');
    }

    protected function getArguments()
    {
        $arguments = parent::getArguments();

        $arguments[] = ['class', InputArgument::OPTIONAL, 'The name of class will be return by facade.'];

        return $arguments;
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $replacements = [
            "@see \\DummyTarget\n" => "@see \\DummyTarget\n * @mixin \\DummyTarget\n",
            'DummyTarget' => $this->argument('class') ?: $this->rootNamespace().$this->argument('name'),
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $stub,
        );
    }
}
