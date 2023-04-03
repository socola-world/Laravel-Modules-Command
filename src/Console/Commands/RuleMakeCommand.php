<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\GeneratorCommand;

class RuleMakeCommand extends \Illuminate\Foundation\Console\RuleMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        $class = str_replace(
            "public function validate(string \$attribute, mixed \$value, Closure \$fail): void
    {
        //
    }",
            "public function validate(string \$attribute, mixed \$value, Closure \$fail): void
    {
        if (\$this->passes(\$attribute, \$value)) {
            return;
        }

        \$fail(\$this->message());
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string \$attribute
     * @param mixed \$value
     * @return bool
     */
    public function passes(\$attribute, \$value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be uppercase.';
    }",
            $class
        );

        return $class; // TODO: Change the autogenerated stub
    }
}
