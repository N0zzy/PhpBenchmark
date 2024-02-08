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
    public function ifCtor(): void
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
    public function ternary(): void
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
|  (m) ifCtor1                 |  0                      |  10                |           0 / 200  |          0 / 1600  |        0 / 420.00  |
|  (m) ternary1                |  0                      |  10                |           0 / 200  |           0 / 400  |        0 / 240.00  |
|  (m) ifCtor2                 |  0                      |  100               |           0 / 100  |          0 / 1000  |        0 / 220.00  |
|  (m) ternary2                |  0                      |  100               |           0 / 100  |           0 / 300  |        0 / 164.00  |
|  (m) ifCtor3                 |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2258800  |       0 / 2420.30  |
|  (m) ternary3                |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2252200  |       0 / 2405.90  |
```