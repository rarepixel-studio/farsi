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

    protected static function nLeapYears($year)
    {
        $a = (int)($year / 400);
        $b = $year % 400;
        $c = (int)($b / 100);
        $d = $b % 100;
        $e = (int)($d / 4);
        return (int) ($a * 97 + $c * 24 + $e);

    }

    /**
     * @return int
     */
    protected function numberOfLeapYearsPast()
    {
        return static::nLeapYears($this->getYear() - 1);
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
     * @param int $nDays
     * @return static
     */
    public static function fromInteger($nDays)
    {
        $fourCentury = 365 * 400 + static::nLeapYears(400);
        $century = 365 * 100 + static::nLeapYears(100);
        $fourYear = 365 * 4 + 1;
        $year = 1 + floor($nDays / $fourCentury) * 400;
        $nDays %= $fourCentury;
        $year += floor($nDays / $century) * 100;
        $nDays %= $century;
        $year += floor($nDays / $fourYear) * 4;
        $nDays %= $fourYear;
        $year += floor($nDays / 365);
        $nDays %= 365;

        if(static::isLeapYear($year) && $nDays >= 60) {
            if($nDays == 60) {
                $month = 2;
                $day = 29;
            } else {
                $month = MiscHelpers::binarySearch($nDays, static::$cumulativeDaysInMonth);
                $day = $nDays - static::$cumulativeDaysInMonth[$month - 1] - 2;
            }
        } else {
            $month = MiscHelpers::binarySearch($nDays, static::$cumulativeDaysInMonth);
            $day = $nDays - static::$cumulativeDaysInMonth[$month - 1] - 1;
        }

        return new static($year, $month, $day);
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