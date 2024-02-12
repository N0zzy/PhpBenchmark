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

use N0zzy\PhpBenchmark\Attributes\BenchmarkGC;
use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\Services\Views;

/**
 * Class PhpBenchmarkBase
 */
abstract class PhpBenchmarkBase
{
    /**
     * @var array|string[]
     */
    protected array $subjects = [];

    protected int $memoryLimit = 0;

    /**
     * @var Views|null
     */
    protected ?Views $view = null;

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->view = new Views();
        $this->run();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    private function run(): void
    {
        $this->view->getHeaders();
        foreach ($this->subjects as &$subject){
            if (!class_exists($subject)) continue;
            $this->classIterator($subject);
        }
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
        /**
         * @var Benchmark $refBenchmark
         */
        $refBenchmark = $refClass->getAttributes(Benchmark::class)[0]->newInstance();
        $refMemory = $refClass->getAttributes(BenchmarkMemory::class);
        $refMemory =
            ($refMemory[0] ?? false) &&
            $refMemory[0]->newInstance() instanceof BenchmarkMemory
        ;
        $refMemoryLimit = $refClass->getAttributes(BenchmarkMemory::class);
        $refMemoryLimit = ($refMemoryLimit[0] ?? false) ? $refMemoryLimit[0]->newInstance()->limit : 0;
        if($refMemoryLimit > 0 && $this->memoryLimit < $refMemoryLimit){
            $this->memoryLimit = $refMemoryLimit;
            ini_set("memory_limit","{$this->memoryLimit}M");
            $this->view->getMemory($refMemoryLimit);
        }
        $classFullName = $refClass->getNamespaceName() . '\\' . $refClass->getName();
        $refMethods = $refClass->getMethods();
        /**
         * @var Benchmark $oMemory
         */
        $this->objectIterator($classFullName, $refBenchmark->count, $o);
        foreach ($refMethods as &$method){
            /**
             * @var Benchmark $benchmark
             */
            $benchmark = $method->getAttributes(Benchmark::class)[0]->newInstance();
            if($benchmark instanceof Benchmark){
                $memory = $this->getMethodMemoryToBool($method, $refMemory);
                $gc = $this->getMethodGCToBool($method);
                $params  = $this->getMethodParamsToArray($method);
                $this->methodIterator($o, $method, $params, $benchmark->count, $memory, $gc);
            }
            $this->view->clear();
        }
    }

    /**
     * @param string $classFullName
     * @param int $count
     * @param object|null $o
     * @param bool $isMemory
     * @param bool $isGc
     * @return void
     */
    private function objectIterator
    (
        string $classFullName,
        int $count,
        ?object &$o,
        bool $isMemory = true,
        bool $isGc = true
    )
    : void
    {
        $this->gc();
        $name = explode("\\", $classFullName);
        $this->view->name = end($name);
        $this->view->count = $count;
        for ($i=0; $i < $count; $i++){
            if($isGc) $this->gc();
            memory_reset_peak_usage();
            $memory = -1;
            if($isMemory){
                $memory = memory_get_peak_usage() ;
            }
            $et=-hrtime(true);
            $o = new $classFullName();
            $et+=hrtime(true);

            memory_reset_peak_usage();
            if ($memory >= 0) {
                $memory = (memory_get_peak_usage() - $memory) / 1024;
                $this->view->memory += $memory;
            }
            $this->view->times[] = $et;
        }
        $this->view->getObject();
        $this->view->clear();
    }

    /**
     * @param object $o
     * @param \ReflectionMethod $method
     * @param $params
     * @param int $count
     * @param bool $isMemory
     * @param bool $isGC
     * @return void
     * @throws \ReflectionException
     */
    private function methodIterator
    (
        object $o,
        \ReflectionMethod $method,
        $params,
        int $count,
        bool $isMemory = true,
        bool $isGC = false
    )
    : void
    {
        $this->view->count = $count;
        $this->view->name = $method->getName();

        $this->gc();

        for ($i = 0; $i < $count; $i++){
            if($isGC) $this->gc();
            memory_reset_peak_usage();
            $memory = -1;
            if($isMemory){
                $memory = memory_get_peak_usage() ;
            }

            $et=-hrtime(true);
            $method->invokeArgs($o, $params);
            $et+=hrtime(true);

            if ($memory >= 0) {
                $memory = (memory_get_peak_usage() - $memory) / 1024;
                $this->view->memory += $memory;
            }
            $this->view->times[] = $et;
            memory_reset_peak_usage();
        }

        $this->view->getMethod();
        $this->view->clearTimes();
    }

    /**
     * @param int $ms
     * @return void
     */
    private function gc
    (
        int $ms = 10
    )
    : void
    {
        gc_collect_cycles();
        gc_enable();
        usleep($ms);
    }

    /**
     * @param \ReflectionMethod $method
     * @param bool $refMemory
     * @return bool
     */
    private function getMethodMemoryToBool
    (
        \ReflectionMethod $method,
        bool $refMemory
    )
    : bool
    {
        $memory = $method->getAttributes(BenchmarkMemory::class);
        return ($memory[0] ?? false) && $memory[0]->newInstance() instanceof BenchmarkMemory || $refMemory;
    }

    /**
     * @param \ReflectionMethod $method
     * @return bool
     */
    private function getMethodGCToBool
    (
        \ReflectionMethod $method
    )
    : bool
    {
        $cold = $method->getAttributes(BenchmarkGC::class);
        return ($cold[0] ?? false) && $cold[0]->newInstance() instanceof BenchmarkGC;
    }

    /**
     * @param \ReflectionMethod $method
     * @return array
     */
    private function getMethodParamsToArray
    (
        \ReflectionMethod $method
    )
    : array
    {
        $params = $method->getAttributes(BenchmarkMethod::class);
        return ($params[0] ?? false) && ($arrParams = $params[0]->newInstance()) instanceof BenchmarkMethod
            ?  $arrParams->args : [];
    }
}