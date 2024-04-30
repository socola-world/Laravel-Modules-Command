<?php

namespace SocolaDaiCa\LaravelModulesCommand\Console\Traits;

use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use SocolaDaiCa\LaravelBadassium\Helpers\PromptsAble;
use SocolaDaiCa\LaravelModulesCommand\Facades\OpenPhpstorm;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Path;

trait CommonCommand
{
    use PromptsAble;

    /**
     * @var \Nwidart\Modules\Laravel\Module
     */
    protected $module;

    public function __construct()
    {
        parent::__construct();

        if (!empty($this->getName())) {
            $this->setName('cms:'.$this->getName());
        }

        if (!empty($this->signature)) {
            $this->signature = 'cms:'.$this->signature.' {module}';
        }
    }

    public function getModule(): \Nwidart\Modules\Laravel\Module
    {
        if ($this->module == null) {
            $this->module = Module::find(Str::camel($this->argument('module')));
        }

        return $this->module;
    }

    public function getGeneratorFolder($key)
    {
        return $this->getModule()->getPath()
            .'/'
            .$this->laravel['config']['modules']['paths']['generator'][$key]['path'];
    }

    public function getGeneratorPath($key, $name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->getGeneratorFolder($key)
            .'/'
            .str_replace('\\', '/', $name)
            .'.php';
    }

    public function getGeneratorNamespace($key)
    {
        $namespace = $this->rootNamespace().$this->laravel['config']['modules']['paths']['generator'][$key]['namespace'];

        return str_replace('/', '\\', $namespace);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
            ...parent::getArguments(),
        ];
    }

    protected function promptForMissingArgumentsUsing()
    {
        $prompts = parent::promptForMissingArgumentsUsing();

        if (!empty($prompts['name']) && !empty($this->type)) {
            $prompts['name'] = match ($this->type) {
                'Model' => fn () => $this->anticipate(
                    $prompts['name'][0],
                    fn ($input) => collect([
                        'Admin',
                        'User',
                        'Role',
                        'Permission',
                        'Post',
                    ])
                        ->filter(fn ($item) => $item != $input)
                        ->filter(fn ($item) => Str::startsWith($item, $input))
                        ->all(),
                ),
                'Controller' => fn () => $this->autoCompleteClassName(
                    $prompts['name'][0],
                    config('modules.paths.generator.controller.path'),
                    'Controller'
                ),
                // todo: make:command auto complete
                default => $prompts['name'],
            };
        }

        return $prompts;
    }

    public function autoCompleteClassName($question, $namespacePath, $postFix = '')
    {
        return $this->anticipate(
            $question,
            function ($input) use ($postFix, $namespacePath) {
                $module = Module::find($this->argument('module'));
                $parent = Path::join(
                    $module->getPath(),
                    $namespacePath,
                );
                $namespaces = [];
                $queue = [
                    $parent,
                ];

                while (count($queue) > 0) {
                    $current = array_shift($queue);
                    $namespaces[] = $current;
                    $queue = array_merge(
                        $queue,
                        \Illuminate\Support\Facades\File::directories(
                            $current
                        )
                    );
                }

                $namespaces = array_map(function ($directory) use ($parent) {
                    $directory = Str::after(
                        $directory,
                        $parent
                    );

                    $directory = trim($directory, '\\/');
                    $directory .= '\\';

                    return $directory;
                }, $namespaces);

                $namespaces[] = $input;

                $postFixRegex = $this->getPostFixRegex($postFix);

                $namespaces = collect($namespaces)
                    ->map(function ($item) use ($postFix, $postFixRegex) {
                        $item = str_replace('/', '\\', $item);

                        if (Str::endsWith($item, '\\')) {
                            return trim($item, '\\');
                        }

                        if (!preg_match($postFixRegex, $item)) {
                            return $item.$postFix;
                        }

                        return preg_replace($postFixRegex, $postFix, $item);
                    })
                    ->filter(fn ($item) => Str::startsWith($item, $input))
                    ->filter(fn ($item) => $item != $input)
                    ->values()
                    ->all()
                ;

                return $namespaces;
            }
        );
    }

    public function getPostFixRegex($postFix)
    {
        if ($postFix == '') {
            return '';
        }

        $postFixRegex = [];

        $length = Str::length($postFix);

        for ($i = 0; $i < $length; $i++) {
            $postFixRegex[] = Str::substr($postFix, 0, $length - $i);
        }

        $postFixRegex = implode('|', $postFixRegex);

        return "/({$postFixRegex})$/";
    }

    public function handle()
    {
        $result = parent::handle();

        OpenPhpstorm::openAll();

        return $result;
    }

    /**
     * Run the given the console command.
     *
     * @param string|\Symfony\Component\Console\Command\Command $command
     *
     * @return int
     */
    protected function runCommand($command, array $arguments, OutputInterface $output)
    {
        if (Str::startsWith($command, 'cms:') == false) {
            $command = 'cms:'.$command;
            $arguments = array_merge(
                [
                    'module' => $this->argument('module'),
                ],
                $arguments,
            );
        }

        return parent::runCommand($command, $arguments, $output);
    }
}
