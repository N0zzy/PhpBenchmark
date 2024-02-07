<?php

namespace Stafred\PhpBenchmark\Attributes;

#[\Attribute]
class BenchmarkDefault
{
    public function __construct
    (
        public mixed $value
    )
    {}
}