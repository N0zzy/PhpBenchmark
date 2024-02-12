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
        "arg1" => 1,
        "arg2" => 1
    ])]
    public static function test1(int $arg1, int $arg2): void
    {
        $a = str_repeat( $arg1, rand($arg2, 1000) );
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
|__Name________________________|__Memory(RSS, kb)________|__Count_____________|__Time(min, s/ns)___|__Time(max, s/ns)___|__Time(avg, s/ns)___|
|  Php Memory Limit: 500M
|  (c) BenchmarkTest           |  0.078125               |  10                |          0 / 5100  |          0 / 9100  |          0 / 6770  |
|  (m) test1                   |  55.9296875             |  100               |           0 / 400  | 0.0215 / 21490200  |   0.0002 / 215557  |
|  (m) test2                   |  56.3828125             |  100               |           0 / 300  |         0 / 14500  |           0 / 662  |
```
