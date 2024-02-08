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
    #[Benchmark(count: 100000)]
    public function null1(): void
    {
        $a = null;
        if($a === null){

        }
    }
    #[Benchmark(count: 100000)]
    public function null2(): void
    {
        $a = null;
        if($a == null){

        }
    }
    #[Benchmark(count: 100000)]
    public function null3(): void
    {
        $a = null;
        if(is_null($a)){

        }
    }
    #[Benchmark(count: 100000)]
    public function null4(): void
    {
        $a = null;
        if(empty($a)){

        }
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
|  (m) null1                   |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2227000  |        0 / 175.91  |
|  (m) null2                   |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2205600  |        0 / 174.89  |
|  (m) null3                   |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2221600  |        0 / 174.38  |
|  (m) null4                   |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2234700  |        0 / 173.57  |
```