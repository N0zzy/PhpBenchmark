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
    public function function1(): void
    {
        $a = function(){

        };
        $a();
    }
    #[Benchmark(count: 1000)]
    public function function2(): void
    {
        $a = fn() => null;
        $a();
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
|  (c) BenchmarkTest           |  0.0390625              |  10                |          0 / 1100  |          0 / 6100  |          0 / 3030  |
|  (m) function1               |  385.453125             |  1000              |           0 / 200  |  0.0023 / 2260600  |          0 / 2534  |
|  (m) function2               |  385.453125             |  1000              |           0 / 200  |  0.0023 / 2328300  |          0 / 2574  |
```