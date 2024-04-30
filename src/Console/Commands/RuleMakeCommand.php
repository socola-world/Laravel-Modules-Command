<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;

class RuleMakeCommand extends \Illuminate\Foundation\Console\RuleMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $oldClass = $class = parent::buildClass($name);

        $from = 'public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }';
        $from = str_replace("\r\n", "\n", $from);
        $to = "public function validate(string \$attribute, mixed \$value, Closure \$fail): void
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
    }";
        $to = str_replace("\r\n", "\n", $to);

        return str_replace(
            $from,
            $to,
            $class
        );
    }
}
