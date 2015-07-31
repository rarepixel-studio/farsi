<?php
namespace Opilo\Farsi;

use Doctrine\Instantiator\Exception\InvalidArgumentException;

class GeorgianDate extends Date
{

    protected static $cumulativeDaysInMonth = [
        0,
        31,
        59,
        90,
        120,
        151,
        181,
        212,
        243,
        273,
        304,
        334,
        365,
    ];

    protected static $daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    /**
     * @return int
     */
    protected function numberOfLeapYearsPast()
    {
        $y = $this->getYear() - 1;
        $a = (int)($y / 400);
        $b = $y % 400;
        $c = (int)($b / 100);
        $d = $b % 100;
        $e = (int)($d / 4);
        return (int) ($a * 97 + $c * 24 + $e);
    }

    /**
     * @return int the rank of day in the current year
     */
    public function dayOfYear()
    {
        $m = $this->getMonth() - 1;
        $d = static::$cumulativeDaysInMonth[$m] + $this->getDay();
        if($m > 1 && static::isLeapYear($this->year)) {
            $d++;
        }
        return $d;
    }

    /**
     * @param int $year
     * @return bool
     */
    public static function isLeapYear($year)
    {
        return ! ($year % 4) && ($year % 100 || ! ($year % 400));
    }

    /**
     * Validates the constructed date
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function validate()
    {
        parent::validate();

        $d = $this->getDay();
        $m = $this->getMonth();

        if($d > static::$daysInMonth[$m - 1]) {
            if(!($m == 2 && $d == 29 && static::isLeapYear($this->getYear()))) {
                throw new InvalidArgumentException();
            }
        }
    }
}