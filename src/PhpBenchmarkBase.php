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

use ReflectionAttribute;
use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\Services\Arguments;
use N0zzy\PhpBenchmark\Services\BufferArguments;
use N0zzy\PhpBenchmark\Services\BufferClasses;
use N0zzy\PhpBenchmark\Services\BufferMethods;
use N0zzy\PhpBenchmark\Services\ResultsView;

/**
 * Class PhpBenchmarkBase
 */
abstract class PhpBenchmarkBase
{
    /**
     * @var array|string[]
     */
    protected array $subjects = [];
    /**
     * @var array|BufferClasses[]
     */
    protected array $buffer = [];
    /**
     * @var ResultsView|null
     */
    protected ?ResultsView $view = null;

    /**
     * @throws \ReflectionException
     */
    protected function __construct()
    {
        $this->view = new ResultsView();
        $this->run();
        $this->view->set($this->buffer);
        $this->view->render();
    }

    /**
     * @throws \ReflectionException
     */
    private function run(): void
    {
        foreach ($this->subjects as $subject) {
            if (!class_exists($subject)) continue;
            $this->classIterator($subject);
        }

        $this->execute();
    }

    /**
     * @param string $subject
     * @return void
     * @throws \ReflectionException
     */
    private function classIterator
    (
        string $subject
    )
    : void
    {
        $refClass = new \ReflectionClass($subject);
        if ($refClass->getName() == Benchmark::class) return;

        $classFullName = $refClass->getNamespaceName() . '\\' . $refClass->getName();
        if (!isset($this->buffer[$classFullName])) {
            $buffer = new BufferClasses($classFullName);
            $this->setArguments(
                $buffer,
                $refClass->getAttributes(Benchmark::class)[0]->getArguments()
            );
            $refMethods = $refClass->getMethods();
            foreach ($refMethods as $method) {
                $this->setMethod($buffer, $method);
            }
            $this->buffer[$classFullName] = $buffer;
        }

        $benchmarkMemory = $refClass->getAttributes(BenchmarkMemory::class);
        if(count($benchmarkMemory) == 1){
            ini_set("memory_limit", ($benchmarkMemory[0]->getArguments()['limit'] * 1024 * 1024) . 'M');
        }
    }


    /**
     * @param BufferArguments $buffer
     * @param array $args
     * @return void
     */
    private function setArguments(
        BufferArguments &$buffer,
        array $args
    )
    : void
    {
        foreach ($args as $key => $value) {
            if (!property_exists($buffer->arguments, $key)) continue;
            $buffer->arguments->{$key} = $value;
        }
    }

    private function setMethod
    (
        BufferClasses &$buffer,
        \ReflectionMethod $method
    )
    : void
    {
        $methodName = $method->getName();
        if (!isset($buffer->methods[$methodName])) {
            $bufferMethod = new BufferMethods;
            $bufferMethod->method = $method;
            $this->attributesIterator($method, $bufferMethod);
            $buffer->methods[$methodName] = $bufferMethod;
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function execute(): void
    {
        /**
         * @var BufferClasses $object
         */
        foreach ($this->buffer as $key => $item) {
            for ($i = 0; $i < $item->arguments->count; $i++) {
                $o = $this->runObject($item->classFullName, $item->arguments);
                $this->buffer[$item->classFullName]->results->countClass++;
                /**
                 * @var BufferMethods $method
                 */
                foreach ($item->methods as $method) {
                    $methodName = $method->method->getName();
                    if (!array_key_exists($methodName, $item->results->countMethods)) {
                        $item->results->countMethods[$methodName] = 0;
                        $item->results->memoryMethods[$methodName] = 0;
                    }
                    $this->runMethod(
                        $item->classFullName,
                        $o,
                        $method->method,
                        $method->arguments,
                        $method->methodArguments
                    );
                }
            }
        }
    }

    private function attributesIterator(
        $method,
        &$bufferMethod
    )
    : void
    {
        /**
         * @var ReflectionAttribute $attr
         */
        foreach ($method->getAttributes() as $attr) {
            $o = $attr->newInstance();

            if( $o instanceof Benchmark ) {
                $this->setArguments(
                    $bufferMethod,
                    $method->getAttributes(Benchmark::class)[0]->getArguments()
                );
            }
            else
            if( $o instanceof BenchmarkMethod ) {
                $this->setMethodArguments(
                    $bufferMethod,
                    $attr->getArguments()['args']
                );
            }
        }
    }

    /**
     * @param string $classFullName
     * @param Arguments $args
     * @return object
     */
    private function runObject
    (
        string $classFullName,
        Arguments $args
    )
    : object
    {
        $memory = -1;
        if ($args->memory) {
            $memory = getrusage()["ru_maxrss"];
        }

        $object = new $classFullName();

        if ($memory > -1) {
            $memory = getrusage()["ru_maxrss"] - $memory;
            $this->buffer[$classFullName]->results->memoryClass += $memory;
        }
        return $object;
    }


    /**
     * @param string $classFullName
     * @param object $o
     * @param \ReflectionMethod $method
     * @param Arguments $args
     * @param array $mArgs
     * @return void
     * @throws \ReflectionException
     */
    private function runMethod
    (
        string            $classFullName,
        object            $o,
        \ReflectionMethod $method,
        Arguments         $args,
        array             $mArgs
    )
    : void
    {

        for ($i = 0; $i < $args->count; $i++) {
            $memory = -1;
            $name = $method->getName();

            if ($args->memory) {
                memory_reset_peak_usage();
                $memory = memory_get_peak_usage() ;
            }

            $start_time = hrtime(true);
            $method->invokeArgs($o, $mArgs);
            $end_time = hrtime(true);

            if ($memory > -1) {
                $memory = (memory_get_peak_usage() - $memory) / 1024;
                memory_reset_peak_usage();
                $this->buffer[$classFullName]->results->memoryMethods[$name] += $memory;
            }

            $execution_time_ns = $end_time - $start_time;

            $this->buffer[$classFullName]->results->countMethods[$name]++;
            $this->buffer[$classFullName]->results->timeMethods[$name][] = $execution_time_ns;

        }
    }

    /**
     * @param BufferMethods $buffer
     * @param array $arguments
     * @return void
     */
    private function setMethodArguments(BufferMethods &$buffer, array $arguments): void
    {
        $buffer->methodArguments = $arguments;
    }
}