<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Str;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\GeneratorCommand;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    use GeneratorCommand;

    protected function buildClass($name)
    {
        $class = parent::buildClass($name);
        $class = Str::replace("\n    //\n", '', $class);

        $replaces = [
            'use Illuminate\Database\Eloquent\Model;' => 'use SocolaDaiCa\LaravelBadassium\Contracts\Models\Model;',
            'use Illuminate\Database\Eloquent\Relations\Pivot;' => 'use SocolaDaiCa\LaravelBadassium\Contracts\Models\Pivot;',
        ];

        if (class_exists($this->getNamespace($name).'\Model')) {
            $replaces['use Illuminate\Database\Eloquent\Model;'] = 'use \SocolaDaiCa\LaravelBadassium\Contracts\Models\Model;';
        }

        if (class_exists($this->getNamespace($name).'\Pivot')) {
            $replaces['use Illuminate\Database\Eloquent\Relations\Pivot;'] = 'use \SocolaDaiCa\LaravelBadassium\Contracts\Models\Pivot;';
        }

        $class = str_replace(
            array_keys($replaces),
            array_values($replaces),
            $class,
        );

        $table = Str::snake(Str::pluralStudly($this->argument('name')));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $phpParse = app(PhpParse::class);

        return $phpParse
            ->parseAst($class)
            ->addMethod("
                protected \$table = '{$table}';
            ")
            ->addMethod('
                protected $fillable = [];
            ')
            ->addMethod('
                protected $guarded = [];
            ')
            ->__toString()
        ;
    }
}
