<?php

namespace SocolaDaiCa\LaravelIdeHelperCompoship\Console\Commands;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use ReflectionObject;

class LaravelIdeHelperModelsCommand extends ModelsCommand
{
    protected function isRelationNullable(string $relation, Relation $relationObj): bool
    {
        $reflectionObj = new ReflectionObject($relationObj);

        if (in_array($relation, ['hasOne', 'hasOneThrough', 'morphOne'], true)) {
            $defaultProp = $reflectionObj->getProperty('withDefault');
            $defaultProp->setAccessible(true);

            return !$defaultProp->getValue($relationObj);
        }

        if (!$reflectionObj->hasProperty('foreignKey')) {
            return false;
        }

        $fkProp = $reflectionObj->getProperty('foreignKey');
        $fkProp->setAccessible(true);

        if ($relation === 'belongsTo') {
            return $this->issetNullableColumns($fkProp->getValue($relationObj))
                || !$this->issetForeignKeyConstraintsColumns($fkProp->getValue($relationObj));
        }

        return $this->issetNullableColumns($fkProp->getValue($relationObj));
    }

    /**
     * @param array|string $columns
     */
    protected function issetNullableColumns($columns): bool
    {
        return (bool) Arr::first(
            (array) $columns,
            function ($value) {
                return isset($this->nullableColumns[$value]);
            },
        );
    }

    protected function issetForeignKeyConstraintsColumns($columns): bool
    {
        return (bool) Arr::first(
            (array) $columns,
            function ($value) {
                return in_array($value, $this->foreignKeyConstraintsColumns, true);
            },
        );
    }
}
