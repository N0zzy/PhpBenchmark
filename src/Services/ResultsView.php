<?php
/**
 * PhpBenchmark
 * @author N0zzy <https://github.com/N0zzy>
 * @version 0.1 2023-02-07
 * @link https://github.com/N0zzy/PhpBenchmark
 * @license MIT
 * @license https://github.com/N0zzy/PhpBenchmark/blob/master/LICENSE
 * @copyright N0zzy
 * @since 0.1
 */

namespace Stafred\PhpBenchmark\Services;

/**
 * Class ResultsView
 */
class ResultsView
{
    /**
     * @var array|BufferClasses[] $buffer
     */
    private array $buffer = [];
    /**
     * @return void
     */
    public function render(): void
    {
        $header = [];
        array_map(function ($arr) use (&$header) {

            $header[] = count($header) < 1 || isset( $arr[1])
                ?  $this->addWhiteSpace($arr[0], true, $arr[1])
                : $this->addWhiteSpace($arr[0]);
        }, [
            ["Name", 30],
            ["Memory(kb)", 25],
            ["Count", 20],
            ["Time(min, s/ns)"],
            ["Time(max, s/ns)"],
            ["Time(avg, s/ns)"],
        ]);

        $strHeader = "|". implode("|", $header) . "|";
        $lengthAll = strlen($strHeader);

        $body = [];

        /**
         * @var BufferClasses $buffer
         */
        foreach ($this->buffer as $buffer) {
            $body[] = "|";
            $arrClassName = explode("\\", $buffer->classFullName);

            array_map( function ($arr) use (&$body) {
                $body[] = isset($arr[1])
                    ? $this->addWhiteSpace($arr[0], false, $arr[1])
                    : $this->addWhiteSpaceEnd($arr[0], false);
                $body[] = "|";
            }, [
                ["(c) " . end($arrClassName), 30],
                [$buffer->results->memoryClass, 25],
                [$buffer->results->countClass, 20],
                [0],
                [0],
                [0],
            ]);
            $body[] = "\n";

            foreach ($buffer->results->memoryMethods as $key => $value) {
                $body[] = "|";
                $tMin = min($buffer->results->timeMethods[$key]);
                $tMax = max($buffer->results->timeMethods[$key]);
                $tAvg = array_sum($buffer->results->timeMethods[$key]) / count($buffer->results->timeMethods[$key]);
                array_map( function ($arr) use (&$body) {
                    $body[] = isset($arr[1])
                        ? $this->addWhiteSpace($arr[0], false, $arr[1])
                        : $this->addWhiteSpaceEnd($arr[0], false);
                    $body[] = "|";
                }, [
                    ["(m) " . $key, 30],
                    [$value, 25],
                    [$buffer->results->countMethods[$key], 20],
                    [ $this->getTimeToString($tMin) ],
                    [ $this->getTimeToString($tMax) ],
                    [ $this->getTimeToString($tAvg) ],
                ]);
                $body[] = "\n";
            }
        }
        echo "{$strHeader}\n" . implode("", $body);
    }

    /**
     * @param array|BufferClasses[] $buffer
     * @return void
     */
    public function set
    (
        array $buffer
    )
    : void
    {
        $this->buffer = $buffer;
    }

    /**
     * @param string|int|float $str
     * @param bool $add
     * @param int $number
     * @return string
     */
    private function addWhiteSpace(
        string|int|float $str,
        bool $add = true,
        int $number = 20
    )
    : string
    {
        $this->packDataForView( $str, $separator, $length, $add);
        if (strlen($str) > 20) {
            $str = substr($str, 0, 20) . "...";
        }
        return  $str . $this->getWhiteSpaceRepeat($separator, $length, $number);
    }

    /**
     * @param string|int|float $str
     * @param bool $add
     * @param int $number
     * @return string
     */
    private function addWhiteSpaceEnd(
        string|int|float $str,
        bool $add = true,
        int $number = 20
    )
    : string
    {
        $this->packDataForView( $str, $separator, $length, $add, true);
        return  $this->getWhiteSpaceRepeat($separator, $length, $number) . $str;
    }

    /**
     * @param $str
     * @param $separator
     * @param $length
     * @param bool $add
     * @param bool $reverse
     * @return void
     */
    private function packDataForView(
        &$str,
        &$separator,
        &$length,
        bool $add,
        bool $reverse = false
    )
    : void
    {
        $str = !$reverse ? "__" . (string)$str : (string)$str . "__";

        $separator = "_";
        if(!$add) {
            $separator = " ";
            $str = str_replace("_", $separator, $str);
        }
        $length = strlen($str);
    }

    /**
     * @param $separator
     * @param $length
     * @param $number
     * @return string
     */
    private function getWhiteSpaceRepeat(
        $separator,
        $length,
        $number
    )
    : string
    {
        return str_repeat($separator, ($length < $number ? $number - $length : $number));
    }

    /**
     * @param int|float $timeNSec
     * @return string
     */
    private function getTimeToString(
        int|float $timeNSec
    )
    : string
    {
        $timeSec = $timeNSec/1000000;
        if (is_float($timeNSec)) {
            $timeNSec = $this->roundNumber($timeNSec);
        }
        if (is_float($timeSec)) {
            $timeSec = $this->roundNumber($timeSec);
        }
        return $timeSec. " / " . $timeNSec;
    }

    /**
     * @param $number
     * @return float|int
     */
    private function roundNumber(
        $number
    )
    : float|int
    {
        if ($number >= 1000) {
            return round($number, 1);
        } elseif ($number >= 100) {
            return round($number, 2);
        } elseif ($number >= 10) {
            return round($number, 3);
        } else {
            return round($number, 4);
        }
    }
}