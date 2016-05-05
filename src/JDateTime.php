<?php

namespace Opilo\Farsi;

use DateTime;

class JDateTime extends JalaliDate
{
    protected $hour;
    protected $minute;
    protected $second;

    public function __construct($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        $this->hour = (int) $hour;
        $this->minute = (int) $minute;
        $this->second = (int) $second;

        parent::__construct($year, $month, $day);

        $this->validateTime();
    }

    /**
     * @param DateTime $dateTime
     *
     * @return static
     */
    public static function fromDateTime(DateTime $dateTime)
    {
        return DateConverter::dateTimeToJDateTime($dateTime);
    }

    /**
     * @param string $format
     * @param string $strDate
     *
     * @return static
     */
    public static function fromFormat($format, $strDate)
    {
        return JalaliParser::createJDateTimeFromFormat($format, $strDate);
    }

    /**
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @return int
     */
    public function secondsSinceMidnight()
    {
        return $this->getSecond() + 60 * ($this->getMinute() + 60 * $this->getHour());
    }

    protected function validateTime()
    {
        if ($this->hour < 0 || $this->minute < 0 || $this->second < 0
        || $this->hour >= 24 || $this->minute >= 60 || $this->second >= 60) {
            throw new InvalidDateException($this);
        }
    }
}
