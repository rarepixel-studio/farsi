<?php

namespace Opilo\Farsi;

use InvalidArgumentException;

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
        $this->year = (int) $year;
        $this->month = (int) $month;
        $this->day = (int) $day;
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
    abstract public function dayOfYear();

    /**
     * Validates the constructed date.
     *
     * @throws InvalidArgumentException
     */
    protected function validate()
    {
        $d = $this->getDay();
        $m = $this->getMonth();
        $y = $this->getYear();

        if (!($d > 0 && $m > 0 && $y > 0 && $m <= 12 && $d <= 31)) {
            throw new InvalidArgumentException();
        }
    }

    abstract protected function numberOfLeapYearsPast();
}
