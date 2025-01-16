<?php

namespace SocolaDaiCa\LaravelModulesCommand\Editor;

use ReflectionClass;
use ReflectionException;

class File
{
    private ReflectionClass $reflectionClass;

    private string $class;

    /**
     * @throws ReflectionException
     */
    public function __construct(string $class)
    {
        $this->class = $class;
        $this->reflectionClass = new ReflectionClass($class);
    }

    public function hasMethod($method)
    {
        $this->reflectionClass->hasMethod($method);
    }
}
