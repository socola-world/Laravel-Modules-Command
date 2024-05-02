<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse\Stmt;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PhpParser\Node;

class Raw_ extends Node\Stmt
{
    public array $contents;

    public function __construct(array|string $contents, array $attributes = [])
    {
        parent::__construct();

        if (is_string($contents)) {
            $contents = trim($contents, " \t");
            // dd($contents);
            $contents = preg_split("/\r\n|\r|\n/", $contents);

            if (empty($contents[0])) {
                array_shift($contents);
            }

            if (empty(Arr::last($contents))) {
                array_pop($contents);
            }

            preg_match('/^(\s+)/', $contents[0], $matches);

            foreach ($contents as $index => $content) {
                $contents[$index] = Str::replaceFirst($matches[0], '', $content);
            }

            $contents[0] = trim($contents[0]);
        }

        $this->contents = $contents;
    }

    public function getType(): string
    {
        return 'Stmt_Raw';
    }

    public function getSubNodeNames(): array
    {
        return [];
    }
}
