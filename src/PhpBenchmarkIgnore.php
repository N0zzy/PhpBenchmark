<?php
/**
 * PhpBenchmark
 * @author N0zzy <https://github.com/N0zzy>
 * @version 0.3 2023-02-15
 * @link https://github.com/N0zzy/PhpBenchmark
 * @license MIT
 * @license https://github.com/N0zzy/PhpBenchmark/blob/master/LICENSE
 * @copyright N0zzy
 * @since 0.3
 */

namespace N0zzy\PhpBenchmark;

use Composer\Autoload\ClassLoader;
use N0zzy\PhpBenchmark\Attributes\BenchmarkDefault;
use N0zzy\PhpBenchmark\Attributes\BenchmarkGC;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\Services\MemoryEnum;
use N0zzy\PhpBenchmark\Services\OutputEnum;

/**
 * Class PhpBenchmarkIgnore
 */
abstract class PhpBenchmarkIgnore
{
    /**
     * @var array|string[]
     */
    protected array $listIgnore = [
        PhpBenchmarkIgnore::class,
        BenchmarkDefault::class,
        BenchmarkGC::class,
        BenchmarkMemory::class,
        BenchmarkMethod::class,
        PhpBenchmarkIgnore::class,
        PhpBenchmarkBase::class,
        PhpBenchmark::class,
        ClassLoader::class,
        PhpBenchmarkSettings::class,
        MemoryEnum::class,
        OutputEnum::class,
    ];
}