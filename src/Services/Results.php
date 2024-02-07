<?php

namespace Stafred\PhpBenchmark\Services;


final class Results
{
    public bool $memoryClassView = false;
    public int|float $memoryClass = 0;
    public int $countClass = 0;
    public array $memoryMethodsView = [];
    public array $countMethods = [];
    public array $memoryMethods = [];
    public array $timeMethods = [];
}