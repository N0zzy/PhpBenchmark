<?php
/**
 * PhpBenchmark
 * @author N0zzy <https://github.com/N0zzy>
 * @version 0.3 2023-02-15
 * @link https://github.com/N0zzy/PhpBenchmark
 * @license MIT
 * @license https://github.com/N0zzy/PhpBenchmark/blob/master/LICENSE
 * @copyright N0zzy
 * @since 0.3
 */

namespace N0zzy\PhpBenchmark;

use N0zzy\PhpBenchmark\Services\MemoryEnum;
use N0zzy\PhpBenchmark\Services\OutputEnum;

/**
 * Class PhpBenchmarkSettings
 */
#[\Attribute]
final class PhpBenchmarkSettings
{
    /**
     * @var bool
     */
    public bool $gc = false;
    /**
     * @var MemoryEnum|int
     */
    public MemoryEnum|int $memory = MemoryEnum::MEDIUM;
    /**
     * @var OutputEnum|string
     */
    public OutputEnum|string $output = OutputEnum::Console;

    /**
     * @param array $settings
     */
    public function __construct
    (
        public array $settings = []
    )
    {}

    /**
     * @return void
     */
    public function install(): void
    {
        foreach ($this->settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}