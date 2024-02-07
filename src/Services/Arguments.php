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
namespace N0zzy\PhpBenchmark\Services;

use N0zzy\PhpBenchmark\Attributes\BenchmarkDefault;

/**
 * Class Arguments
 */
final class Arguments
{
    /**
     * @var int
     */
    #[BenchmarkDefault(value: 1)]
    public int $count = 1;
    /**
     * @var bool
     */
    #[BenchmarkDefault(value: false)]
    public bool $memory = false;

    /**
     * @return void
     */
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