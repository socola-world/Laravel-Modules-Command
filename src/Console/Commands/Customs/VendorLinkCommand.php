<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands\Customs;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelModulesCommand\Console\Traits\CommonCommand;

class VendorLinkCommand extends \Illuminate\Foundation\Console\StorageLinkCommand
{
    use CommonCommand;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        $this->signature = str_replace('storage:link', 'cms:vendor:link {module?}', $this->signature);

        parent::__construct();
    }

    protected function links()
    {
        $modules = [];

        if ($this->argument('module')) {
            $modules[] = $this->getModule();
        } else {
            $modules = Module::all();
        }

        $links = [];

        foreach ($modules as $module) {
            $vendorNamespace = "{$module->getComposerAttr('name')}";
            $author = Str::before($vendorNamespace, '/');
            $vendorRelativePath = "vendor/{$vendorNamespace}";
            File::makeDirectory(public_path("vendor/{$author}"), '0000', true, true);

            $from = "{$module->getPath()}/public/{$vendorRelativePath}";

            if (!File::isDirectory($from)) {
                continue;
            }

            $to = public_path($vendorRelativePath);

            if (
                File::isDirectory($to)
                && realpath($to) !== realpath($from)
            ) {
                File::deleteDirectory($to);
            }

            $links[$to] = "{$module->getPath()}/public/{$vendorRelativePath}";
        }

        return $links;
    }
}
