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
    #[Benchmark(count: 1000)]
    public function tryCatch1(): bool
    {
        foreach ([1,2,3] as $value) {
            try {
                if($value == 3) throw new Exception();
            }
            catch (Exception) {
                return false;
            }
        }
        return true;
    }
    #[Benchmark(count: 1000)]
    public function tryCatch2(): bool
    {
        $e = new Exception();
        foreach ([1,2,3] as $value) {
            try {
                if($value == 3) throw $e;
            }
            catch (Exception) {
                return false;
            }
        }
        return true;
    }
    #[Benchmark(count: 1000)]
    public function noTryCatch(): bool
    {
        foreach ([1,2,3] as $value) {
            if($value == 3) {
                return false;
            }
        }
        return true;
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
|  (c) BenchmarkTest           |  0.0390625              |  10                |           0 / 900  |          0 / 7000  |          0 / 3130  |
|  (m) tryCatch1               |  3305.1171875           |  1000              |          0 / 1000  |  0.0024 / 2386200  |          0 / 8022  |
|  (m) tryCatch2               |  3312.0078125           |  1000              |          0 / 1000  |  0.0023 / 2292200  |         0 / 21424  |
|  (m) noTryCatch              |  4.8125                 |  1000              |           0 / 100  |  0.0023 / 2253600  |          0 / 6744  |
```