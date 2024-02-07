# Simple Php Benchmark

### Example

```php
#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use N0zzy\PhpBenchmark\Attributes\Benchmark;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMemory;
use N0zzy\PhpBenchmark\Attributes\BenchmarkMethod;
use N0zzy\PhpBenchmark\PhpBenchmark;


#[Benchmark( count: 10 )]
#[BenchmarkMemory( limit: 500 )]
class BenchmarkTest
{
    private string $a = "";
    private int $b = 0;


    #[Benchmark(count: 100)]
    #[BenchmarkMethod(args: [
        "test" => 1,
        "test2" => 1
    ])]
    public static function test1(int $test, int $test2): void
    {
        $a = str_repeat( $test, rand($test2, 1000) );
    }

    #[Benchmark(count: 100)]
    public function test2(): void
    {
        $this->b = rand(1, 1000);
        $this->a = str_repeat( 'a', $this->b );
    }
}

new PhpBenchmark(
        BenchmarkTest::class
);
```

### Install (composer)
```text
composer require n0zzy/phpbenchmark
```

### Run (for terminal/console)
```text
php your_php_script_benchmark
```

### Results
```text
|__Name________________________|__Memory(kb)_____________|__Count_____________|__Time(min, s/ns)___|__Time(max, s/ns)___|__Time(avg, s/ns)___|
|  (c) BenchmarkTest           |  0                      |  10                |                 0  |                 0  |                 0  |
|  (m) test1                   |  0                      |  1000              |           0 / 200  |  0.0023 / 2255000  |        0 / 2590.3  |
|  (m) test2                   |  0                      |  1000              |           0 / 200  |  0.0023 / 2336200  |        0 / 2612.4  |
```
