<?php

namespace Stafred\PhpBenchmark\Services;

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