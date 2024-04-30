<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use Illuminate\Support\Str;

trait GeneratorDatabaseCommand
{
    use GeneratorCommand;

    public function getGeneratorPath($key, $name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $name = str_replace('\\', '/', $name);

        $name = preg_replace(
            '/^'.preg_quote(
                config("modules.paths.generator.{$key}.namespace"),
                '/'
            ).'\//',
            '',
            $name
        );

        return $this->getGeneratorFolder($key)
            .'/'
            .$name
            .'.php';
    }
}
