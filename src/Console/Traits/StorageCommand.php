<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

trait StorageCommand
{
    use CommonCommand;

    public function __construct()
    {
        if (!empty($this->getName())) {
            $this->setName('cms:'.$this->getName());
        }

        if (!empty($this->signature)) {
            $this->signature = 'cms:'.$this->signature.' {module?}';
        }

        parent::__construct();
    }

    protected function links()
    {
        $modules = [];
        $links = [];

        if ($this->argument('module')) {
            $modules[] = $this->getModule();
        } else {
            $modules = Module::all();
        }

        foreach ($modules as $module) {
            $vendorNamespace = "{$module->getComposerAttr('name')}";
            $vendorRelativePath = "vendor/{$vendorNamespace}";

            $author = Str::before($vendorNamespace, '/');
            File::makeDirectory(public_path("vendor/{$author}"), '0000', true, true);

            $links[public_path($vendorRelativePath)] = "{$module->getPath()}/public/{$vendorRelativePath}";
        }

        return $links;
    }
}
