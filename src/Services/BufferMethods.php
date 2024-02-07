<?php

namespace Stafred\PhpBenchmark\Services;

final class BufferMethods extends BufferArguments
{
    public \ReflectionMethod $method;

    public array $methodArguments = [];


    public function __construct()
    {
        parent::__construct();
    }
}