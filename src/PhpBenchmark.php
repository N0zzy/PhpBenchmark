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

namespace N0zzy\PhpBenchmark;

/**
 * Class PhpBenchmark
 */
final class PhpBenchmark extends PhpBenchmarkBase
{
    /**
     * @param string|string[] ...$classes
     * @throws \ReflectionException
     */
    public function __construct(string ...$classes)
    {
        $this->subjects = $classes;
        parent::__construct();
    }
}