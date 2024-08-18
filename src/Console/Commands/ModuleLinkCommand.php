<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Facades\File;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;

class ModuleLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link Installed Modules to Modules folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = File::glob(base_path('vendor/socoladaica/*/module.json'));
        $ignoreFolders = [];

        foreach ($files as $file) {
            $file = realpath($file);
            $folder = dirname($file);
            $module = basename($folder);
            $modulesDir = base_path('Modules');
            $moduleDir = "{$modulesDir}/{$module}";

            if (is_dir($moduleDir)) {
                continue;
            }

            if (is_link($moduleDir)) {
                File::delete($moduleDir);
            }

            File::link($folder, $moduleDir);
            $ignoreFolders[] = "Modules/{$module}";
            $this->info("The [{$folder}] link has been connected to [{$moduleDir}].\n");
        }
        sort($ignoreFolders);
        File::put(base_path('Modules/.gitignore'), implode("\n", $ignoreFolders));
    }
}
