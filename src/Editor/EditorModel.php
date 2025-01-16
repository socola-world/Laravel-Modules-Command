<?php

namespace SocolaDaiCa\LaravelModulesCommand\Editor;

use Illuminate\Support\Str;

class EditorModel extends EditorClass
{
    public function addRelation(string $type, string $returnType, $relation, $related, array $foreignKey, array $localKey)
    {
        if (count($foreignKey) > 1) {
            $foreignKey = "[\n'".implode("',\n'", $foreignKey)."',\n];";
        } else {
            $foreignKey = "'{$foreignKey[0]}'";
        }

        if (count($localKey) > 1) {
            $localKey = "[\n'".implode("',\n'", $localKey)."',\n];";
        } else {
            $localKey = "'{$localKey[0]}'";
        }

        $typeStudly = Str::studly($type);

        $code = "
            /**
             * @return \\Illuminate\\Database\\Eloquent\\Relations\\{$typeStudly}<{$related}>|{$related}{$returnType}
             */
            public function {$relation}()
            {
                return \$this->{$type}(
                    \\{$related}::class,
                    {$foreignKey},
                    {$localKey},
                );
            }
        ";

        $this->phpParse->addMethod($code);
    }

    public function addBelongsToRelation($relation, $related, array $foreignKey, array $localKey)
    {
        $this->addRelation('belongsTo', '', $relation, $related, $foreignKey, $localKey);
    }

    public function addHasManyRelation($relation, $related, array $foreignKey, array $localKey)
    {
        $this->addRelation('hasMany', '[]', $relation, $related, $foreignKey, $localKey);
    }

    public function addBelongsToManyRelation(string $relations, string $related, mixed $foreignKey, mixed $localKey)
    {
        $this->addRelation('belongsToMany', '[]', $relations, $related, $foreignKey, $localKey);
    }
}
