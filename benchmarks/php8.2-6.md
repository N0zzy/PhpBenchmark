```php
#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\PhpBenchmark;

#[Benchmark( count: 1)]
#[BenchmarkMemory( limit: 500 )]
class BenchmarkTest
{
    #[Benchmark(count: 10)]
    public function ifCtor1(): void
    {
        $a = null;
        if($a === null){
            $a = 0;
        }
        else {
            $a = 1;
        }
    }
    #[Benchmark(count: 10)]
    public function ternary1(): void
    {
        $a = null;
        $a = $a === null ? 0 : 1;
    }
    #[Benchmark(count: 100)]
    public function ifCtor2(): void
    {
        $a = null;
        if($a === null){
            $a = 0;
        }
        else {
            $a = 1;
        }
    }
    #[Benchmark(count: 100)]
    public function ternary2(): void
    {
        $a = null;
        $a = $a === null ? 0 : 1;
    }
    #[Benchmark(count: 1000)]
    public function ifCtor3(): void
    {
        $a = null;
        if($a === null){
            $a = 0;
        }
        else {
            $a = 1;
        }
    }
    #[Benchmark(count: 1000)]
    public function ternary3(): void
    {
        $a = null;
        $a = $a === null ? 0 : 1;
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
|  (c) BenchmarkTest           |  0.0390625              |  10                |          0 / 1200  |          0 / 5700  |          0 / 2700  |
|  (m) ifCtor1                 |  0                      |  10                |           0 / 200  |          0 / 3600  |           0 / 570  |
|  (m) ternary1                |  0                      |  10                |           0 / 200  |          0 / 4000  |           0 / 640  |
|  (m) ifCtor2                 |  0                      |  100               |           0 / 200  |          0 / 6300  |           0 / 348  |
|  (m) ternary2                |  0                      |  100               |           0 / 100  |          0 / 2900  |           0 / 213  |
|  (m) ifCtor3                 |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2273800  |          0 / 2404  |
|  (m) ternary3                |  1.515625               |  1000              |           0 / 100  |  0.0024 / 2448600  |          0 / 2584  |
```