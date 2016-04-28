<?php

namespace Opilo\Farsi;

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
     * @return mixed
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @return mixed
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @return mixed
     */
    public function getSecond()
    {
        return $this->second;
    }

    protected function validateTime()
    {
        if ($this->hour < 0 || $this->minute < 0 || $this->second < 0
        || $this->hour >= 24 || $this->minute >= 60 || $this->second >= 60) {
            throw new InvalidDateException($this);
        }
    }
}
