<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands\Customs;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;
use Symfony\Component\Filesystem\Path;

class FacadeDocsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:facade:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::all();
        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
        $facadesFolders = [];

        foreach ($modules as $module) {
            $facadesFolder = Path::join($module->getPath(), config('modules.paths.generator.facade.path'));

            if (File::isDirectory($facadesFolder) == false) {
                continue;
            }

            $facadesFolder = realpath($facadesFolder);
            $facadesFolder = Str::after($facadesFolder, base_path());
            $facadesFolder = trim($facadesFolder, '\\/');

            $facadesFolders[] = $facadesFolder;
        }

        if (empty($facadesFolders)) {
            $this->warn('No facades found.');

            return;
        }

        Artisan::call('autodoc:facades', [
            'paths' => $facadesFolders,
        ], $this->output);
    }
}
