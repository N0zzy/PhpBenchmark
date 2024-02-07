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

namespace Stafred\PhpBenchmark\Attributes;

/**
 * Class BenchmarkDefault
 */
#[\Attribute]
class BenchmarkDefault
{
    /**
     * @param mixed $value
     */
    public function __construct
    (
        public mixed $value
    )
    {}
}