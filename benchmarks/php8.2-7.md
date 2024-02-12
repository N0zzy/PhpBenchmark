```php
#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\PhpBenchmark;


interface IBenchmarkTest {

}

#[Benchmark( count: 10)]
#[BenchmarkMemory( limit: 500 )]
class Test1
{

}

#[Benchmark( count: 10000)]
#[BenchmarkMemory( limit: 500 )]
class Test2
{

}

#[Benchmark( count: 10)]
#[BenchmarkMemory( limit: 500 )]
class TestInterface1 implements IBenchmarkTest
{

}

#[Benchmark( count: 10000)]
#[BenchmarkMemory( limit: 500 )]
class TestInterface2 implements IBenchmarkTest
{

}

new PhpBenchmark(
    Test1::class,
    TestInterface1::class,
    Test2::class,
    TestInterface2::class
);
```
### Results
```text
|__Name________________________|__Memory(RSS, kb)________|__Count_____________|__Time(min, s/ns)___|__Time(max, s/ns)___|__Time(avg, s/ns)___|
|  (c) Test1                   |  0.390625               |  10                |           0 / 200  |          0 / 1200  |        0 / 310.00  |
|  (c) Test2                   |  390.625                |  10000             |           0 / 100  |          0 / 1400  |        0 / 130.50  |
|  (c) TestInterface1          |  0.390625               |  10                |           0 / 100  |           0 / 700  |        0 / 190.00  |
|  (c) TestInterface2          |  390.625                |  10000             |           0 / 100  |          0 / 1700  |        0 / 154.19  |
```