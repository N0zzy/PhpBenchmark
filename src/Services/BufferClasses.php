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
 * Class BufferClasses
 */
final class BufferClasses extends BufferArguments
{
    /**
     * @var string
     */
    public string $classFullName = '';
    /**
     * @var array|\ReflectionMethod[]
     */
    public array $methods = [];
    /**
     * @var Results|null
     */
    public ?Results $results = null;
    /**
     * @param string $classFullName
     */
    public function __construct
    (
        string $classFullName = ""
    )
    {
        $this->classFullName = $classFullName;
        $this->results = new Results();
        parent::__construct();
    }
}