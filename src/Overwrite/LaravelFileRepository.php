<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite;

use Illuminate\Support\Str;

class LaravelFileRepository extends \Nwidart\Modules\Laravel\LaravelFileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }

    /**
     * @inheritDoc
     */
    public function find(string $name)
    {
        foreach ($this->all() as $module) {
            if ($module->getLowerName() === Str::kebab($name)) {
                return $module;
            }
        }
    }

    public function getScanPaths(): array
    {
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            return [];
        }

        return parent::getScanPaths();
    }

    protected function formatCached($cached)
    {
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            return [];
        }

        return parent::formatCached($cached); // TODO: Change the autogenerated stub
    }
}
