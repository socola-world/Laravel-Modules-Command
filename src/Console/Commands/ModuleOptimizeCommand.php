<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Commands;

use Illuminate\Support\Composer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Json;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Reflection;
use ReflectionClass;
use SocolaDaiCa\LaravelBadassium\Contracts\Console\Command;
use Symfony\Component\Finder\SplFileInfo;
use function Illuminate\Filesystem\join_paths;

class ModuleOptimizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the modules for better performance.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::all();
        foreach ($modules as $module) {
            /** @var \SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module */
            /** @var Json $json */
            $json = $module->json();
            $providers = $json->get('providers');
            foreach ($providers as $provider) {
                $providerReflectionClass = new ReflectionClass($provider);
                $providerFileName = $providerReflectionClass->getFileName();
                $content = file_get_contents($providerFileName);
                $content = $this->optimizeTranslations($module, $content);
                $content = $this->optimizeViews($module, $content);
                $content = $this->optimizeAssets($module, $content);
                $content = $this->optimizeMigrations($module, $content);

                file_put_contents($providerFileName, $content);
            }

        }
    }

    private function optimizeTranslations(\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module, false|string $content)
    {
        $dir = join_paths(
            $module->getPath(),
            config('modules.paths.generator.lang.path')
        );
        $dir = realpath($dir);
        $hasTranslation = collect(File::allFiles($dir))
            ->contains(function (SplFileInfo $splFileInfo) {
                return Str::endsWith($splFileInfo->getRealPath(), ['.php', '.json']);
            })
        ;
        $pattern = '/(\s*)((?:\/\/\s*)?)(\$this->registerTranslations\(\);)/';
        return preg_replace($pattern, $hasTranslation ? '$1$3' : '$1// $3', $content);
    }

    public function optimizeViews(\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module, $content)
    {
        $dir = join_paths(
            $module->getPath(),
            config('modules.paths.generator.view.path')
        );
        $dir = realpath($dir);
        $hasView = collect(File::allFiles($dir))
            ->contains(function (SplFileInfo $splFileInfo) {
                return Str::endsWith($splFileInfo->getRealPath(), '.blade.php');
            })
        ;
        $pattern = '/(\s*)((?:\/\/\s*)?)(\$this->registerViews\(\);)/';
        return preg_replace($pattern, $hasView ? '$1$3' : '$1// $3', $content);
    }

    public function optimizeAssets(\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module, $content)
    {
        $dir = join_paths(
            $module->getPath(),
            'public'
        );
        $dir = realpath($dir);
        $hasAsset = collect(File::allFiles($dir))
            ->contains(function (SplFileInfo $splFileInfo) {
                return Str::endsWith($splFileInfo->getRealPath(), [
                    '.css',
                    '.js',
                    'png',
                    'jpg',
                    'jpeg',
                    'gif',
                    'svg',
                ]);
            })
        ;
        $pattern = '/(\s*)((?:\/\/\s*)?)(\$this->registerAssets\(\);)/';
        return preg_replace($pattern, $hasAsset ? '$1$3' : '$1// $3', $content);
    }

    private function optimizeMigrations(\SocolaDaiCa\LaravelModulesCommand\Overwrite\Module $module, $content)
    {
        $dir = join_paths(
            $module->getPath(),
            config('modules.paths.generator.migration.path')
        );
        $dir = realpath($dir);
        $hasMigration = collect(File::allFiles($dir))
            ->contains(function (SplFileInfo $splFileInfo) {
                return Str::endsWith($splFileInfo->getRealPath(), '.php');
            })
        ;
        $pattern = '/(\s*)((?:\/\/\s*)?)(\$this->registerMigrations\(\);)/';
        return preg_replace($pattern, $hasMigration ? '$1$3' : '$1// $3', $content);
    }
}
