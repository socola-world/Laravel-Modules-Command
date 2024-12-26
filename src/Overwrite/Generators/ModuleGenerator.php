<?php

namespace SocolaDaiCa\LaravelModulesCommand\Overwrite\Generators;

use Illuminate\Support\Str;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use SocolaDaiCa\LaravelModulesCommand\Overwrite\Stub;

class ModuleGenerator extends \Nwidart\Modules\Generators\ModuleGenerator
{
    protected bool $flagUpdate = false;

    protected function getLowerNameReplacement()
    {
        return Str::kebab($this->getName());
    }

    /**
     * Get the contents of the specified stub file by given stub name.
     *
     * @return string
     */
    protected function getStubContents($stub)
    {
        return (new Stub(
            '/'.$stub.'.stub',
            $this->getReplacement($stub),
        )
        )->render();
    }

    public function generateFiles()
    {
        foreach ($this->getFiles() as $stub => $file) {
            $path = $this->module->getModulePath($this->getName()).$this->getGenerateFilePath($stub, $file);

            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            if (!file_exists($path)) {
                $this->filesystem->put($path, $this->getStubContents($stub));

                $this->console->info("Created : {$path}");
            } elseif (in_array($stub, config('modules.stubs.force_overwire', []))) {
                $this->filesystem->put($path, $this->getStubContents($stub));

                $this->console->warn("Overwire : {$path}");
            }
        }
    }

    public function setFlagUpdate(bool $flagUpdate)
    {
        $this->flagUpdate = $flagUpdate;

        return $this;
    }

    protected function getGenerateFilePath($stub, $file)
    {
        $replaces = $this->getReplacement($stub);

        foreach ($replaces as $search => $replace) {
            $file = str_replace('$'.strtoupper($search).'$', $replace, $file);
            $file = str_replace('__'.strtoupper($search).'__', $replace, $file);
        }

        return $file;
    }

    public function getAuthorRoleReplacement()
    {
        return $this->module->config('composer.author.role');
    }

    public function getYearReplacement()
    {
        return date('Y');
    }

    public function getAuthorHomepageReplacement()
    {
        return config('laravel-modules-command.composer.author.homepage');
    }

    public function getPhpReplacement()
    {
        return config('laravel-modules-command.composer.php');
    }

    public function getPathMigrationsReplacement()
    {
        return GenerateConfigReader::read('migration')->getPath();
    }

    public function getPathConfigReplacement()
    {
        return GenerateConfigReader::read('config')->getPath();
    }

    public function getPathViewsReplacement()
    {
        return GenerateConfigReader::read('views')->getPath();
    }

    public function getPathLangReplacement()
    {
        return GenerateConfigReader::read('lang')->getPath();
    }

    public function getLicenseReplacement()
    {
        return [
            'afl-3.0' => 'Academic Free License v3.0',
            'agpl-3.0' => 'GNU Affero General Public License v3.0',
            'apache-2.0' => 'Apache license 2.0',
            'artistic-2.0' => 'Artistic license 2.0',
            'bsd-2-clause' => 'BSD 2-clause "Simplified" license',
            'bsd-3-clause-clear' => 'BSD 3-clause Clear license',
            'bsd-3-clause' => 'BSD 3-clause "New" or "Revised" license',
            'bsl-1.0' => 'Boost Software License 1.0',
            'cc-by-4.0' => 'Creative Commons Attribution 4.0',
            'cc-by-sa-4.0' => 'Creative Commons Attribution Share Alike 4.0',
            'cc0-1.0' => 'Creative Commons Zero v1.0 Universal',
            'cc' => 'Creative Commons license family',
            'ecl-2.0' => 'Educational Community License v2.0',
            'epl-1.0' => 'Eclipse Public License 1.0',
            'epl-2.0' => 'Eclipse Public License 2.0',
            'eupl-1.1' => 'European Union Public License 1.1',
            'gpl-2.0' => 'GNU General Public License v2.0',
            'gpl-3.0' => 'GNU General Public License v3.0',
            'gpl' => 'GNU General Public License family',
            'isc' => 'ISC',
            'lgpl-2.1' => 'GNU Lesser General Public License v2.1',
            'lgpl-3.0' => 'GNU Lesser General Public License v3.0',
            'lgpl' => 'GNU Lesser General Public License family',
            'lppl-1.3c' => 'LaTeX Project Public License v1.3c',
            'mit' => 'MIT',
            'mpl-2.0' => 'Mozilla Public License 2.0',
            'ms-pl' => 'Microsoft Public License',
            'ncsa' => 'University of Illinois/NCSA Open Source License',
            'ofl-1.1' => 'SIL Open Font License 1.1',
            'osl-3.0' => 'Open Software License 3.0',
            'postgresql' => 'PostgreSQL License',
            'unlicense' => 'The Unlicense',
            'wtfpl' => 'Do What The F*ck You Want To Public License',
            'zlib' => 'zLib License',
        ][config('laravel-modules-command.composer.license')];
    }

    /**
     * Generate the module.
     */
    public function generate(): int
    {
        $name = $this->getName();

        if ($this->module->has($name)) {
            if ($this->flagUpdate) {
                /* do nothing */
            } elseif ($this->force) {
                $this->module->delete();
            } else {
                $this->console->error("Module [{$name}] already exist!");

                return E_ERROR;
            }
        }

        $this->generateFolders();

        $this->generateModuleJsonFile();

        if ($this->type !== 'plain') {
            $this->generateFiles();
            $this->generateResources();
        }

        if ($this->type === 'plain') {
            $this->cleanModuleJsonFile();
        }

        $this->activator->setActiveByName($name, $this->isActive);

        $this->console->info("Module [{$name}] created successfully.");

        return 0;
    }

    /**
     * Generate the module.json file.
     */
    private function generateModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()).'module.json';

        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0775, true);
        }

        if (!file_exists($path)) {
            $this->filesystem->put($path, $this->getStubContents('json'));

            $this->console->info("Created : {$path}");
        }
    }

    /**
     * Remove the default service provider that was added in the module.json file
     * This is needed when a --plain module was created.
     */
    private function cleanModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()).'module.json';

        $content = $this->filesystem->get($path);
        $namespace = $this->getModuleNamespaceReplacement();
        $studlyName = $this->getStudlyNameReplacement();

        $provider = '"'.$namespace.'\\\\'.$studlyName.'\\\Providers\\\\'.$studlyName.'ServiceProvider"';

        $content = str_replace($provider, '', $content);

        $this->filesystem->put($path, $content);
    }

    /**
     * Generate the folders.
     */
    public function generateFolders()
    {
        foreach ($this->getFolders() as $key => $folder) {
            $folder = GenerateConfigReader::read($key);

            if (!$folder->generate()) {
                continue;
            }

            $path = $this->module->getModulePath($this->getName()).'/'.$folder->getPath();

            if (!is_dir($path)) {
                $this->filesystem->makeDirectory($path, 0755, true);
            }

            if (config('modules.stubs.gitkeep')) {
                $this->generateGitKeep($path);
            }
        }
    }
}
