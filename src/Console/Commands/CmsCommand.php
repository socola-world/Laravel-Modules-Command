<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use SocolaDaiCa\LaravelAudit\Helper;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;

class CmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Help genrerate code';

    protected $module = '';

    protected $command = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->selectModule();
    }

    public function selectModule()
    {
        /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $moduleTestRector */
        $modules = collect(\Nwidart\Modules\Facades\Module::all());
        $choices = $modules->map(function (\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module) {
            return $module->getLowerName();
        })->values()->all();

        $this->module = $this->choice(
            'Module?',
            $choices
        );

        $this->selectCommand();

        return $this->selectModule();
    }

    public function selectCommand()
    {
        $choices = [
            'back',
            ...collect(array_keys(Artisan::all()))
                ->filter(fn ($command) => Str::startsWith($command, 'cms:'))
                ->filter(fn ($command) => in_array($command, [
                    'cms:make:model',
                    'cms:make:controller',
                    'cms:make:command',
                    'cms:make:facade',
                    // 'cms:make:resource',
                    'cms:ide-helper',
                    'cms:project:setup',
                    'cms:ec2:setup',
                ]))
                ->all(),
        ];

        $this->command = $this->choice(
            "[{$this->module}] Command?",
            $choices,
        );

        if ($this->command == 'back') {
            return;
        }

        $parameters = match ($this->command) {
            'cms:make:model' => [
                '-m' => true,
                '-f' => true,
                '-s' => true,
                'module' => $this->module,
            ],
            // 'cms:make:resource' => $this->makeResource(),
            'cms:make:controller' => [
                'module' => $this->module,
            ],
            'cms:make:command',
            'cms:make:facade' => [
                'module' => $this->module,
            ],
            'cms:ide-helper' => [],
            default => [],
        };

        if ($parameters !== null) {
            Artisan::call($this->command, [
                ...$parameters,
            ], $this->output);
        }

        return $this->selectCommand();
    }

    public function makeResource()
    {
        $models = Helper::getReflectionClassNameByParent(Model::class);
        $model = $this->choice(
            'Model?',
            $models->all(),
        );

        Artisan::call('cms:make:resource', [
            '--model' => $model,
            'module' => $this->module,
        ], $this->output);
    }
}
