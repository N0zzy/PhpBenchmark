<?php

namespace Stafred\PhpBenchmark\Services;

abstract class BufferArguments
{
    /**
     * @var Arguments
     */
    public Arguments $arguments;

    protected function __construct()
    {
        $this->arguments = new Arguments();
    }
}