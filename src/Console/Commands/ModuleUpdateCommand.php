<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class ModuleUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update to date module file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
            $this->call('cms:make:module', [
                'name' => [$module->getLowerName()],
                '--update' => true,
            ]);
        }
    }
}
