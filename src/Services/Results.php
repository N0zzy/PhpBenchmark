<?php
/**
 * PhpBenchmark
 * @author N0zzy <https://github.com/N0zzy>
 * @version 0.1 2023-02-07
 * @link https://github.com/N0zzy/PhpBenchmark
 * @license MIT
 * @license https://github.com/N0zzy/PhpBenchmark/blob/master/LICENSE
 * @copyright N0zzy
 * @since 0.1
 */
namespace Stafred\PhpBenchmark\Services;

/**
 *
 */
final class Results
{
    /**
     * @var bool
     */
    public bool $memoryClassView = false;
    /**
     * @var int|float
     */
    public int|float $memoryClass = 0;
    /**
     * @var int
     */
    public int $countClass = 0;
    /**
     * @var array
     */
    public array $memoryMethodsView = [];
    /**
     * @var array
     */
    public array $countMethods = [];
    /**
     * @var array
     */
    public array $memoryMethods = [];
    /**
     * @var array
     */
    public array $timeMethods = [];
}