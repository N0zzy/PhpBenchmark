# Simple Php Benchmark
____


### Example

```php
#!/usr/bin/php
<?php
require __DIR__ . '/vendor/autoload.php';

use Stafred\PhpBenchmark\Attributes\Benchmark;
use Stafred\PhpBenchmark\Attributes\BenchmarkMemory;
use Stafred\PhpBenchmark\Attributes\BenchmarkMethod;
use Stafred\PhpBenchmark\PhpBenchmark;


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
