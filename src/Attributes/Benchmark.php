<?php

namespace Stafred\PhpBenchmark\Attributes;

#[\Attribute]
final class Benchmark
{

    public function __construct
    (
        public int $count = 10,
        public bool $memory = true
    )
    {}
}