<?php

namespace SocolaDaiCa\LaravelModulesCommand\Editor;

use SocolaDaiCa\LaravelModulesCommand\PhpParse\PhpParse;

class EditorClass
{
    protected $path;

    protected PhpParse $phpParse;

    public function __construct($path)
    {
        $this->path = $path;
        $this->phpParse = app(PhpParse::class)
            ->parseAst(file_get_contents($path))
        ;
    }

    public static function openFile($path)
    {
        return new static($path);
    }

    public function save()
    {
        file_put_contents($this->path, $this->phpParse->__toString());
    }
}
