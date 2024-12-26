<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $replaces = [
            'use use Illuminate\Foundation\Http\FormRequest;' => 'use SocolaDaiCa\LaravelBadassium\Illuminate\Foundation\Http\FormRequest;',
        ];

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $class,
        );

        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
        $module = $this->getModule();
        $phpParse = app(PhpParse::class);

        $phpParse
            ->parseAst($class)
            ->addMethod("
                /**
                 * Get custom attributes for validator errors.
                 *
                 * @return array
                 */
                public function attributes()
                {
                    return __('{$module->getLowerName()}::entity.');
                }
            ")
        ;

        return $phpParse->__toString();
    }
}
