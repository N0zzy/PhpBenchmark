<?php

namespace Stafred\PhpBenchmark\Attributes;

#[\Attribute]
class BenchmarkMethod
{
    public function __construct
    (
        public array $args = []
    )
    {

    }
}