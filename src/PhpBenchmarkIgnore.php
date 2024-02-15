<?php

namespace N0zzy\PhpBenchmark;

use Composer\Autoload\ClassLoader;
use N0zzy\PhpBenchmark\Attributes\BenchmarkDefault;
use N0zzy\PhpBenchmark\Attributes\BenchmarkGC;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;

abstract class PhpBenchmarkIgnore
{
    protected array $listIgnore = [
        BenchmarkDefault::class,
        BenchmarkGC::class,
        BenchmarkMemory::class,
        BenchmarkMethod::class,
        PhpBenchmarkIgnore::class,
        PhpBenchmarkBase::class,
        PhpBenchmark::class,
        ClassLoader::class
    ];
}