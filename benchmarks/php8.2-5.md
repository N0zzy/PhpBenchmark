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
    public function null1(): void
    {
        $a = null;
        if($a === null){

        }
    }
    #[Benchmark(count: 10)]
    public function null2(): void
    {
        $a = null;
        if($a == null){

        }
    }
    #[Benchmark(count: 10)]
    public function null3(): void
    {
        $a = null;
        if(is_null($a)){

        }
    }
    #[Benchmark(count: 10)]
    public function null4(): void
    {
        $a = null;
        if(empty($a)){

        }
    }
    #[Benchmark(count: 1000)]
    public function null10(): void
    {
        $a = null;
        if($a === null){

        }
    }
    #[Benchmark(count: 1000)]
    public function null20(): void
    {
        $a = null;
        if($a == null){

        }
    }
    #[Benchmark(count: 1000)]
    public function null30(): void
    {
        $a = null;
        if(is_null($a)){

        }
    }
    #[Benchmark(count: 1000)]
    public function null40(): void
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
|  (m) null1                   |  0                      |  10                |           0 / 200  |          0 / 1500  |        0 / 430.00  |
|  (m) null2                   |  0                      |  10                |           0 / 200  |           0 / 300  |        0 / 240.00  |
|  (m) null3                   |  0                      |  10                |           0 / 200  |           0 / 300  |        0 / 260.00  |
|  (m) null4                   |  0                      |  10                |           0 / 200  |           0 / 300  |        0 / 270.00  |
|  (m) null10                  |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2266600  |       0 / 2428.50  |
|  (m) null20                  |  1.515625               |  1000              |           0 / 100  |  0.0022 / 2249500  |       0 / 2408.40  |
|  (m) null30                  |  1.515625               |  1000              |           0 / 100  |  0.0023 / 2253000  |       0 / 2412.10  |
|  (m) null40                  |  1.515625               |  1000              |           0 / 100  |  0.0022 / 2247800  |       0 / 2408.00  |
```