<?php

namespace Stafred\PhpBenchmark;

final class PhpBenchmark extends PhpBenchmarkBase
{
    /**
     * @param string|string[] ...$classes
     * @throws \ReflectionException
     */
    public function __construct(string ...$classes)
    {
        $this->subjects = $classes;
        parent::__construct();
    }
}