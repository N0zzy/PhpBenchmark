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
|  (c) BenchmarkTest           |  4                      |  1                 |                 0  |                 0  |                 0  |
|  (m) ifCtor1                 |  0                      |  10                |           0 / 200  |          0 / 1700  |        0 / 410.00  |
|  (m) ternary1                |  0                      |  10                |           0 / 200  |           0 / 400  |        0 / 260.00  |
|  (m) ifCtor2                 |  0                      |  100               |           0 / 100  |          0 / 2100  |        0 / 223.00  |
|  (m) ternary2                |  0                      |  100               |           0 / 100  |           0 / 800  |        0 / 162.00  |
|  (m) ifCtor3                 |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2294200  |       0 / 2451.30  |
|  (m) ternary3                |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2286000  |       0 / 2443.90  |
```