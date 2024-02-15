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

namespace N0zzy\PhpBenchmark\Services;

/**
 * Class ResultsView
 */
class Views
{
    public string $name = "";
    public array $times = [];
    public int|float $memory = 0;
    public bool $isOutput = false;

    /**
     * @param int|float $timeNSec
     * @param bool $zero
     * @return string
     */
    private function getTimeToString
    (
        int|float $timeNSec,
        bool $zero = false
    )
    : string
    {
        $timeSec = $timeNSec/1000000000;
        if (is_float($timeNSec)) {
            $timeNSec = $this->roundNumber($timeNSec);
        }
        if (is_float($timeSec)) {
            $timeSec = $this->roundNumber($timeSec);
        }
        if($zero && $timeNSec < 99) {
            $timeNSec = number_format($timeNSec, 2, '.', '');
        }
        else {
            $timeNSec = round($timeNSec, 0);
        }
        return $timeSec. " / " . $timeNSec;
    }
    /**
     * @param int|float $number
     * @return float|int
     */
    private function roundNumber
    (
        int|float $number
    )
    : float|int
    {
        if ($number >= 1000) {
            return round($number, 1);
        } elseif ($number >= 100) {
            return round($number, 2);
        } elseif ($number >= 10) {
            return round($number, 3);
        }  else {
            return round($number, 4);
        }
    }
    public int $count = 0;

    /**
     * @return void
     */
    public function getHeaders(): void
    {
        $title = [""];
        $title[] = "PhpBenchmark";
        $title[] = "Php version: " . phpversion();
        echo implode("\n", $title) . "\t";

        $header = ["\n"];
        array_map(function ($arr) use (&$header) {
            $header[] = count($header) < 1 || isset( $arr[1])
                ?  $this->addWhiteSpace($arr[0], true, $arr[1])
                : $this->addWhiteSpace($arr[0]);
        }, [
            ["Name", 30],
            ["Memory(RSS, kb)", 25],
            ["Count", 20],
            ["Time(min, s/ns)"],
            ["Time(max, s/ns)"],
            ["Time(avg, s/ns)"],
        ]);

        echo implode("|", $header) . "|\t";
    }

    /**
     * @param int $value
     * @return void
     */
    public function getMemory
    (
        int $value
    )
    : void
    {
        echo "\n|  Php Memory Limit: " . $value . "M\t";
    }

    public function getObject(): void
    {
        if($this->isOutput) return;
        $this->isOutput = true;

        $body = ["\n|"];
        $size = sizeof($this->times);
        $tMin = $size > 0 ? min($this->times) : -1;
        $tMax = $size > 0 ? max($this->times) : -1;
        $tAvg = $size > 0 ? (array_sum($this->times) / count($this->times)) : -1;
        array_map( function ($arr) use (&$body) {
            $body[] = isset($arr[1])
                ? $this->addWhiteSpace($arr[0], false, $arr[1])
                : $this->addWhiteSpaceEnd($arr[0], false);
            $body[] = "|";
        }, [
            [ "(c) " . $this->name, 30 ],
            [ $this->memory, 25 ],
            [ $this->count, 20 ],
            [ $tMin > 0 ? $this->getTimeToString($tMin) : "NaN" ],
            [ $tMax > 0 ? $this->getTimeToString($tMax) : "NaN" ],
            [ $tAvg > 0 ? $this->getTimeToString($tAvg, true) : "NaN" ],
        ]);
        echo implode("", $body);
    }

    public function getMethod(): void
    {
        $body = ["\n|"];
        $tMin = sizeof($this->times) > 0 ? min($this->times) : "NaN";
        $tMax = sizeof($this->times) > 0 ? max($this->times) : "NaN";
        $tAvg = array_sum($this->times) / count($this->times);
        array_map( function ($arr) use (&$body) {
            $body[] = isset($arr[1])
                ? $this->addWhiteSpace($arr[0], false, $arr[1])
                : $this->addWhiteSpaceEnd($arr[0], false);
            $body[] = "|";
        }, [
            [ "(m) " . $this->name, 30 ],
            [ $this->memory, 25 ],
            [ $this->count, 20 ],
            [ $this->getTimeToString($tMin) ],
            [ $this->getTimeToString($tMax) ],
            [ $this->getTimeToString($tAvg, true) ],
        ]);
        echo implode("", $body);

    }

    /**
     * @param string|int|float $str
     * @param bool $add
     * @param int $number
     * @return string
     */
    private function addWhiteSpace
    (
        string|int|float $str,
        bool $add = true,
        int $number = 20
    )
    : string
    {
        $this->packDataForView( $str, $separator, $length, $add);
        if (strlen($str) > 26) {
            $str = substr($str, 0, 26) . "...";
        }
        return  $str . $this->getWhiteSpaceRepeat($separator, $length, $number);
    }



    /**
     * @param string|int|float $str
     * @param bool $add
     * @param int $number
     * @return string
     */
    private function addWhiteSpaceEnd
    (
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
    private function packDataForView
    (
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
    private function getWhiteSpaceRepeat
    (
        $separator,
        $length,
        $number
    )
    : string
    {
        return str_repeat($separator, ($length < $number ? $number - $length : $number));
    }

    public function clear(bool $all = false): void
    {
        $this->times = [];
        $this->memory = 0;
        if( $all ){
            $this->count = 0;
            $this->name = "";
            $this->isOutput = false;
        }
    }
}