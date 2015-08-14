<?php
namespace Opilo\Farsi;

use InvalidArgumentException;

/**
 * Class JalaliDate
 * @package Opilo\Farsi
 *
 * Hejri Shamsi (Iranian) Date
 *
 */
class JalaliDate extends Date
{

    protected static $cumulativeDaysInMonth = [
        0,
        31,
        62,
        93,
        124,
        155,
        186,
        216,
        246,
        276,
        306,
        336,
        366,
    ];

    protected static $daysInMonth = [
        31,
        31,
        31,
        31,
        31,
        31,
        30,
        30,
        30,
        30,
        30,
        29,
    ];

    /**
     * @var array The list of 5-leap-years in Jalali Calendar
     * A 5-leap-year is a leap-year that occurs 5 years after the previous leap-year
     * 0 and INF are here just for ease of computation
     */
    protected static $fiveLeapYears = [
        0,
        9,
        42,
        71,
        104,
        137,
        170,
        203,
        236,
        269,
        302,
        331,
        364,
        397,
        430,
        463,
        496,
        529,
        558,
        591,
        624,
        661,
        690,
        723,
        756,
        789,
        822,
        855,
        888,
        921,
        954,
        983,
        1016,
        1049,
        1082,
        1115,
        1148,
        1181,
        1214,
        1243,
        1280,
        1313,
        1346,
        1375,
        1408,
        1441,
        1478,
        INF,
    ];

    protected static $fiveLeapYearsToInt = [
        0,
        3287,//(new JalaliDate(9, 12, 30))->toInteger
        15340,
        25932,
        37985,
        50038,
        62091,
        74144,
        86197,
        98250,
        110303,
        120895,
        132948,
        145001,
        157054,
        169107,
        181160,
        193213,
        203805,
        215858,
        227911,
        241425,
        252017,
        264070,
        276123,
        288176,
        300229,
        312282,
        324335,
        336388,
        348441,
        359033,
        371086,
        383139,
        395192,
        407245,
        419298,
        431351,
        443404,
        453996,
        467510,
        479563,
        491616,
        502208,
        514261,
        526314,
        539828,
        INF
    ];

    public static function fromInteger($nDays)
    {
        $i = MiscHelpers::binarySearch($nDays, static::$fiveLeapYearsToInt);

        /** @var static $upper upper-bound*/
        $upper = new static(static::$fiveLeapYears[$i], 12, 30);
        /** @var int $delta2 the difference between upper-bound ($upper) and the input ($nDays) in days*/
        $delta2 = $upper->toInteger() - $nDays;

        if(! $delta2) {
            return $upper;
        }

        if($delta2 <= 365) {
            $year = $upper->getYear();
            /** @var static $lower lower-bound */
            $lower = new static($year - 1, 12, 29);
            /** @var int $delta1 the difference between the input ($nDays) and lower-bound ($lower) in days */
            $delta1 = $nDays - $lower->toInteger();
            $month = MiscHelpers::binarySearch($delta1, static::$cumulativeDaysInMonth);
            $day = $delta1 - static::$cumulativeDaysInMonth[$month - 1];
            return new static($year, $month, $day);
        }

        if($delta2 <= 5 * 365) {
            $lower = new static($upper->getYear() - 5, 12, 30);
            $delta1 = $nDays - $lower->toInteger();
            $year =  $lower->getYear() + ceil($delta1 / 365);
            $lower = new static($year, 1, 1);
            $delta1 = $nDays - $lower->toInteger() + 1;
            $month = MiscHelpers::binarySearch($delta1, static::$cumulativeDaysInMonth);
            $day = $delta1 - static::$cumulativeDaysInMonth[$month - 1];
            return new static($year, $month, $day);
        }

        /** @var static $lower last 5-leap year*/
        $lower = new static(static::$fiveLeapYears[$i - 1], 12, 30);
        $delta1 = $nDays - $lower->toInteger();

        /** @var static $lower last leap year*/
        $lower = new static($lower->getYear() + 4 * (int)($delta1 / (4 * 365 + 1)), 12, 30);
        $delta1 = $nDays - $lower->toInteger();

        if(!$delta1) {
            return $lower;
        }
        $year = $lower->getYear() + ceil($delta1 / 365);
        $lower = new static($year, 1, 1);
        $delta1 = $nDays - $lower->toInteger() + 1;
        $month = MiscHelpers::binarySearch($delta1, static::$cumulativeDaysInMonth);
        $day = $delta1 - static::$cumulativeDaysInMonth[$month - 1];
        return new static($year, $month, $day);
    }

    /**
     * @param int $year
     * @return bool
     */
    public static function isLeapYear($year)
    {
        $i = MiscHelpers::binarySearch($year, static::$fiveLeapYears);
        if(static::$fiveLeapYears[$i] == $year) {
            return true;
        }
        $delta = static::$fiveLeapYears[$i] - $year;
        return $delta > 1 && $delta % 4 == 1;
    }

    /**
     * @return int the rank of day in the current year
     */
    public function dayOfYear()
    {
        return static::$cumulativeDaysInMonth[$this->getMonth() - 1] + $this->getDay();
    }

    /**
     * Validates the constructed date
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validate()
    {
        parent::validate();
        $d = $this->getDay();
        $m = $this->getMonth();

        if($d > static::$daysInMonth[$m - 1]) {
            if(!($m == 12 && $d == 30 && static::isLeapYear($this->getYear()))) {
                throw new InvalidArgumentException();
            }
        }
    }

    protected function numberOfLeapYearsPast()
    {
        $y = $this->getYear();

        /** @var int $nHops number of 365-day-years followed a five-leap-year*/
        $nHops = MiscHelpers::binarySearch($y + 1, static::$fiveLeapYears);
        return (int)(($y - $nHops) / 4);
    }
}