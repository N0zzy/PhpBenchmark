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
    #[Benchmark(count: 100)]
    public function countArray1(): void
    {
        $a = count([1,2,3,4]);
    }
    #[Benchmark(count: 100)]
    public function sizeofArray1(): void
    {
        $a = sizeof([1,2,3,4]);
    }
    #[Benchmark(count: 100000)]
    public function countArray2(): void
    {
        $a = count([1,2,3,4]);
    }
    #[Benchmark(count: 100000)]
    public function sizeofArray2(): void
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
|  Php Memory Limit: 500M
|  (c) BenchmarkTest           |  0.0390625              |  10                |           0 / 700  |          0 / 6600  |          0 / 3220  |
|  (m) countArray1             |  0                      |  100               |           0 / 100  |          0 / 6300  |           0 / 255  |
|  (m) sizeofArray1            |  0                      |  100               |           0 / 100  |          0 / 3900  |           0 / 176  |
|  (m) countArray2             |  1.515625               |  100000            |           0 / 100  |  0.0023 / 2263600  |           0 / 150  |
|  (m) sizeofArray2            |  1.515625               |  100000            |           0 / 100  |  0.0023 / 2295200  |           0 / 149  |
```