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
/**
 *
 */
final class BufferMethods extends BufferArguments
{
    /**
     * @var \ReflectionMethod
     */
    public \ReflectionMethod $method;
    /**
     * @var array
     */
    public array $methodArguments = [];

    public function __construct()
    {
        parent::__construct();
    }
}