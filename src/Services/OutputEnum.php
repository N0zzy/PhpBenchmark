<?php
/**
 * PhpBenchmark
 * @author N0zzy <https://github.com/N0zzy>
 * @version 0.32023-02-15
 * @link https://github.com/N0zzy/PhpBenchmark
 * @license MIT
 * @license https://github.com/N0zzy/PhpBenchmark/blob/master/LICENSE
 * @copyright N0zzy
 * @since 0.3
 */
namespace N0zzy\PhpBenchmark\Services;

enum OutputEnum: string
{
    case Console = 'console';
    case Html = 'html';
}