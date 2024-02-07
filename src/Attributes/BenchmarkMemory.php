<?php

namespace Stafred\PhpBenchmark\Attributes;
#[\Attribute]
class BenchmarkMemory
{

    /**
     * @param int $limit limit memory [mb].
     */
    public function __construct
    (
        public int $limit = 150
    )
    {}
}