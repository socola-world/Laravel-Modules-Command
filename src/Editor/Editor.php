<?php

namespace SocolaDaiCa\LaravelModulesCommand\Editor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JsonException;
use SocolaDaiCa\LaravelAudit\Audit\AuditModel;

class Editor
{
    /**
     * @throws JsonException
     */
    public function modelAddMissingRelations(): void
    {
        $classes = AuditModel::getClassMap();
        $classes = array_keys($classes);
        $classes = collect($classes)
            ->filter(function ($class) {
                return is_subclass_of($class, Model::class);
            })
        ;

        $tableToModelClass = [];

        foreach ($classes as $class) {
            $table = (new $class())->getTable();
            $tableToModelClass[$table] = $class;
        }

        /** @var AuditModel[] $tableToAuditModels */
        $tableToAuditModels = [];

        foreach ($tableToModelClass as $table => $modelClass) {
            $auditModelClass = AuditModel::makeByClass($modelClass);
            $tableToAuditModels[$table] = $auditModelClass;
        }

        $foreignKeys = collect([]);

        foreach ($tableToAuditModels as $table => $auditModel) {
            foreach (Schema::getForeignKeys($table) as $foreignKey) {
                $foreignKey['table'] = $table;
                $foreignKeys->push($foreignKey);
            }
        }

        foreach ($foreignKeys as $foreignKey1) {
            // belongsTo
            $table1 = $foreignKey1['table'];
            $auditModel1 = $tableToAuditModels[$table1];
            $editorModel1 = EditorModel::openFile($auditModel1->reflectionClass->getFileName());
            $relations1 = Str::singular(Str::camel($foreignKey['foreign_table']));

            if (!$auditModel1->reflectionClass->hasMethod($relations1)) {
                $editorModel1->addBelongsToRelation(
                    $relations1,
                    $tableToModelClass[$foreignKey['foreign_table']],
                    $foreignKey['columns'],
                    $foreignKey['foreign_columns'],
                );
            }

            // hasMany
            $table2 = $foreignKey1['foreign_table'];
            $auditModel2 = $tableToAuditModels[$table2];
            $editorModel2 = EditorModel::openFile($auditModel2->reflectionClass->getFileName());
            $relations2 = Str::plural(Str::camel($foreignKey['table']));

            if (!$auditModel2->reflectionClass->hasMethod($relations2)) {
                $editorModel2->addHasManyRelation(
                    $relations2,
                    $tableToModelClass[$foreignKey['table']],
                    $foreignKey['columns'],
                    $foreignKey['foreign_columns'],
                );
            }

            foreach ($foreignKeys as $foreignKey2) {
                if ($foreignKey1['table'] == $foreignKey2['table']) {
                    // belongsToMany
                    $relations3 = Str::plural(Str::camel($foreignKey2['foreign_table']));

                    if (!$auditModel2->reflectionClass->hasMethod($relations3)) {
                        $editorModel2->addBelongsToManyRelation(
                            $relations3,
                            $tableToModelClass[$foreignKey['foreign_table']],
                            $foreignKey['columns'],
                            $foreignKey['foreign_columns'],
                        );
                    }
                }
            }

            $editorModel1->save();
            $editorModel2->save();
        }
    }
}
