# Simple Php Benchmark

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

### Run (for terminal/console)
```text
php your_php_script_benchmark
```

### Results
```text
|__Name________________________|__Memory(kb)_____________|__Count_____________|__Time(min, s/ns)___|__Time(max, s/ns)___|__Time(avg, s/ns)___|
|  (c) BenchmarkTest           |  0                      |  10                |                 0  |                 0  |                 0  |
|  (m) test1                   |  0                      |  1000              |      0.0002 / 200  |  2.2835 / 2283500  |   0.0026 / 2606.7  |
|  (m) test2                   |  0                      |  1000              |      0.0002 / 200  |  2.2799 / 2279900  |   0.0025 / 2529.2  |

```
