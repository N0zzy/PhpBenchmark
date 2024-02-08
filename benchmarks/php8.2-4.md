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
    #[Benchmark(count: 100000)]
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

    #[Benchmark(count: 100000)]
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
|  (c) BenchmarkTest           |  4                      |  1                 |                 0  |                 0  |                 0  |
|  (m) tryCatch1               |  330469.1796875         |  100000            |           0 / 900  |  0.0023 / 2309300  |       0 / 1105.30  |
|  (m) tryCatch2               |  330546.3984375         |  100000            |           0 / 900  |  0.0043 / 4336200  |       0 / 1435.10  |
|  (m) noTryCatch              |  196.8125               |  100000            |           0 / 100  |  0.0022 / 2246400  |        0 / 226.71  |
```