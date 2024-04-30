<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class MiddlewareMakeCommand extends \Illuminate\Routing\Console\MiddlewareMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);
        $phpParse = app(PhpParse::class);

        return $phpParse
            ->parseAst($class)
            ->addMethod('
                public static function using()
                {
                    return static::class.\':\'.implode(\',\', func_get_args());
                }
            ')
            ->__toString()
        ;
    }
}
