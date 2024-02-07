<?php

namespace Stafred\PhpBenchmark\Services;

use Stafred\PhpBenchmark\Attributes\BenchmarkDefault;


final class Arguments
{
    #[BenchmarkDefault(value: 1)]
    public int $count = 1;
    #[BenchmarkDefault(value: false)]
    public bool $memory = false;

    public function clear(): void
    {
        $refClass = new \ReflectionClass($this);
        $refAttributes = $refClass->getAttributes();
        foreach ($this as $key => $value) {
            if(array_key_exists($key, $refAttributes)){
                $this->{$key} = $refAttributes[$key];
            }
        }
    }
}