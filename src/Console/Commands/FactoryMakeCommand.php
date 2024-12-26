<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorDatabaseCommand;

class FactoryMakeCommand extends \Illuminate\Database\Console\Factories\FactoryMakeCommand
{
    use GeneratorDatabaseCommand;

    protected function getPath($name)
    {
        $name = (string) Str::of($name)->replaceFirst($this->rootNamespace(), '')->finish('Factory');

        return $this->getGeneratorPath('factory', $name);
    }

    protected function buildClass($name)
    {
        return str_replace(
            'namespace Database\Factories\Database\Factories;',
            'namespace '.$this->getGeneratorNamespace('factory').';',
            parent::buildClass($name),
        );
    }

    protected function qualifyModel(string $model)
    {
        return str_replace(
            $this->rootNamespace().'Models\\',
            $this->getGeneratorNamespace('model').'\\',
            parent::qualifyModel($model),
        );
    }
}
