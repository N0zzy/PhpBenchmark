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
    public function countArray(): void
    {
        $a = count([1,2,3,4]);
    }

    #[Benchmark(count: 100000)]
    public function sizeofArray(): void
    {
        $a = sizeof([1,2,3,4]);
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
|  (m) countArray              |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2193500  |        0 / 170.96  |
|  (m) sizeofArray             |  1.515625               |  100000            |           0 / 100  |  0.0022 / 2181200  |        0 / 170.17  |
```