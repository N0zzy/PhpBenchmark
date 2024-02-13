```php
#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\PhpBenchmark;

$value1 = function($value){
    return $value;
};
$value2 = fn($value)=>$value;

#[Benchmark( count: 1)]
#[BenchmarkMemory( limit: 500 )]
class BenchmarkTest
{
    #[Benchmark(count: 100000)]
    public function for1(): void
    {
        $arr = [];
        for ($i = 0; $i < 3; $i++){
            $arr[] = $i;
        }
    }
    #[Benchmark(count: 100000)]
    public function foreach1(): void
    {
        $arr = [];
        foreach ([1,2,3] as $value){
            $arr[] = $value;
        }
    }
    #[Benchmark(count: 100000)]
    public function foreach2(): void
    {
        $arr = [];
        foreach ([1,2,3] as $key => $value){
            $arr[] = $value;
        }
    }
    #[Benchmark(count: 100000)]
    public function arrayMap1(): void
    {
        $arr = array_map(fn($value)=>$value, [1,2,3]);
    }
    #[Benchmark(count: 100000)]
    public function arrayMap2(): void
    {
        $arr = array_map(function($value){
            return $value;
        }, [1,2,3]);
    }
    #[Benchmark(count: 100000)]
    public function arrayMap3(): void
    {
        global $value1;
        $arr = array_map($value1, [1,2,3]);
    }
    #[Benchmark(count: 100000)]
    public function arrayMap4(): void
    {
        global $value2;
        $arr = array_map($value2, [1,2,3]);
    }
}

new PhpBenchmark(
        BenchmarkTest::class
);
```
### Results
```text
|__Name________________________|__Memory(RSS, kb)________|__Count_____________|__Time(min, s/ns)___|__Time(max, s/ns)___|__Time(avg, s/ns)___|
|  Php Memory Limit: 500M
|  (c) BenchmarkTest           |  0.0390625              |  10                |           0 / 600  |          0 / 7900  |          0 / 3440  |
|  (m) for1                    |  21098.1328125          |  100000            |           0 / 100  |  0.0024 / 2382300  |           0 / 253  |
|  (m) foreach1                |  21098.90625            |  100000            |           0 / 100  |  0.0023 / 2298600  |           0 / 260  |
|  (m) foreach2                |  21098.90625            |  100000            |           0 / 100  |  0.0022 / 2232400  |           0 / 257  |
|  (m) arrayMap1               |  59379.203125           |  100000            |           0 / 400  |  0.0025 / 2507100  |           0 / 492  |
|  (m) arrayMap2               |  59379.203125           |  100000            |           0 / 400  |  0.0023 / 2295200  |           0 / 492  |
|  (m) arrayMap3               |  3.8046875              |  100000            |           0 / 100  |  0.0023 / 2307400  |           0 / 176  |
|  (m) arrayMap4               |  3.8046875              |  100000            |           0 / 100  |  0.0023 / 2325600  |           0 / 181  |
```