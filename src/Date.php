<?php

namespace Opilo\Farsi;

use InvalidArgumentException;

/**
 * Class Date
 * @package Opilo\Farsi
 *
 * This class and its derived subclasses has no responsibility regarding timezone, and time.
 * They do not have any arithmetic functionality over date, like addDay() or so.
 * They do not have any toString() functionality either.
 * They only represents a date in different calendars (e.g. Jalali, and Georgian).
 * In order to convert a Georgian date between calendars use Opilo\DateConverter static functions.
 *
 */
abstract class Date
{
    protected $year;
    protected $month;
    protected $day;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct($year, $month, $day)
    {
        $this->year = (int)$year;
        $this->month = (int)$month;
        $this->day = (int)$day;
        $this->validate();
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int Month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return int The number of days after 0001-01-01 (the first day in the calendar) + 1
     */
    public function toInteger()
    {
        return ($this->getYear() - 1) * 365 + $this->numberOfLeapYearsPast() + $this->dayOfYear();
    }

    /**
     * @return int the rank of day in the current year
     */
    public abstract function dayOfYear();

    /**
     * Validates the constructed date
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validate()
    {
        $d = $this->getDay();
        $m = $this->getMonth();
        $y = $this->getYear();

        if(!($d > 0 && $m > 0 && $y > 0 && $m <= 12 && $d <= 31)) {
            throw new InvalidArgumentException();
        }
    }

    protected abstract function numberOfLeapYearsPast();
}