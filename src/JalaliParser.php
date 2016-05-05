<?php

namespace Opilo\Farsi;

class JalaliParser
{
    protected static $conversionFunctions = [
        'd' => 'parseDay',
        'j' => 'parseDay',

        'z' => 'parseDayOfYear',

        'm' => 'parseMonth',
        'n' => 'parseMonth',
        'M' => 'parseStrMonth',

        'Y' => 'parseYear',
        'y' => 'parseYearOfCentury',
    ];

    protected static $timeConversionFunctions = [
        'h' => 'parse24Hour',
        'i' => 'parseMinute',
        's' => 'parseSecond',
    ];

    /**
     * @param string $format
     * @param string $date
     * @param bool $includeTime
     *
     * @return JalaliDate|JDateTime
     *
     * @throw InvalidDateException
     */
    public static function createJalaliFromFormat($format, $date, $includeTime = false)
    {
        $dateParts = new DateParts();
        $regexp = '';
        $matchCount = 0;
        $escaped = false;
        $functions = str_split($format);
        foreach ($functions as $function) {
            if ($escaped) {
                $regexp .= preg_quote($function, '/');
                $escaped = false;
            } elseif ($function === '\\') {
                $escaped = true;
            } elseif ($function === '.') {
                $regexp .= '.';
            } elseif ($function === '*') {
                $regexp .= '.*';
            } elseif (array_key_exists($function, static::$conversionFunctions)) {
                $f = static::$conversionFunctions[$function];
                $regexp .= '(' . static::$f($dateParts, $matchCount) . ')';
            } elseif ($includeTime && array_key_exists($function, static::$timeConversionFunctions)) {
                $f = static::$timeConversionFunctions[$function];
                $regexp .= '(' . static::$f($dateParts, $matchCount) . ')';
            } else {
                $regexp .= preg_quote($function, '/');
            }
        }

        if ($dateParts->isAmbiguous()) {
            throw new InvalidDateException($date);
        }

        $regexp = "/^$regexp\$/";
        $date = StringCleaner::digitsToEnglish($date);
        if (!preg_match($regexp, $date, $matches)) {
            throw new InvalidDateException($date);
        }
        $dateParts->fillWithMatches($matches);

        return $dateParts->createJalaliDate($includeTime);
    }

    /**
     * @param string $format
     * @param string $date
     *
     * @return JDateTime
     *
     * @throw InvalidDateException
     */
    public static function createJDateTimeFromFormat($format, $date)
    {
        return static::createJalaliFromFormat($format, $date, true);
    }

    protected static function parseDay(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->day = $matchCount;

        return '[0-9]{1,2}';
    }

    protected static function parseDayOfYear(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->dayOfYear = $matchCount;

        return '[0-9]{1,3}';
    }

    protected static function parseMonth(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->month = $matchCount;

        return '[0-9]{1,2}';
    }

    protected static function parseYear(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->year = $matchCount;

        return '[0-9]*';
    }

    protected static function parseYearOfCentury(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->yearOfCentury = $matchCount;

        return '[0-9]{1,2}';
    }

    protected static function parseStrMonth(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->strMonth = $matchCount;

        return '[الف-ی]*';
    }

    protected static function parse24Hour(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->hour = $matchCount;

        return '[0-9]{1,2}';
    }

    protected static function parseMinute(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->minute = $matchCount;

        return '[0-9]{1,2}';
    }

    protected static function parseSecond(DateParts $dateParts, &$matchCount)
    {
        $matchCount++;
        $dateParts->second = $matchCount;

        return '[0-9]{1,2}';
    }
}

class DateParts
{
    protected static $defaultCentury = 1300;

    protected static $monthNameToMonthNumber = [
        'فروردین'  => 1,
        'اردیبهشت' => 2,
        'خرداد'    => 3,
        'تیر'      => 4,
        'مرداد'    => 5,
        'شهریور'   => 6,
        'مهر'      => 7,
        'آبان'     => 8,
        'آذر'      => 9,
        'دی'       => 10,
        'بهمن'     => 11,
        'اسفند'    => 12,
    ];
    public $year;
    public $yearOfCentury;
    public $day;
    public $month;
    public $strMonth;
    public $dayOfYear;
    public $hour = 0;
    public $minute = 0;
    public $second = 0;

    public function isAmbiguous()
    {
        return $this->hasNoYear() || $this->hasNoDayOfYear();
    }

    protected function hasNoYear()
    {
        return is_null($this->year) && is_null($this->yearOfCentury);
    }

    protected function hasNoDayOfYear()
    {
        return is_null($this->dayOfYear) && ($this->hasNoMonth() || is_null($this->day));
    }

    protected function hasNoMonth()
    {
        return is_null($this->month) && is_null($this->strMonth);
    }

    public function fillWithMatches($matches)
    {
        if ($this->year) {
            $this->year = $matches[$this->year];
        }
        if ($this->yearOfCentury) {
            $this->yearOfCentury = $matches[$this->yearOfCentury];
        }
        if ($this->day) {
            $this->day = $matches[$this->day];
        }
        if ($this->month) {
            $this->month = $matches[$this->month];
        }
        if ($this->dayOfYear) {
            $this->dayOfYear = $matches[$this->dayOfYear];
        }
        if ($this->strMonth) {
            $this->strMonth = $matches[$this->strMonth];
        }
        if ($this->hour) {
            $this->hour = $matches[$this->hour];
        }
        if ($this->minute) {
            $this->minute = $matches[$this->minute];
        }
        if ($this->second) {
            $this->second = $matches[$this->second];
        }
    }

    public function createJalaliDate($includeTime)
    {
        $y = $this->year ?: static::$defaultCentury + $this->yearOfCentury;
        if (!$this->hasNoMonth() && $this->day) {
            $date = new JalaliDate($y, $this->getMonth(), $this->day);
        } else {
            $firstDay = new JalaliDate($y, 1, 1);

            $date = JalaliDate::fromInteger($firstDay->toInteger() - 1 + $this->dayOfYear);
        }

        if ($includeTime) {
            return new JDateTime($date->getYear(), $date->getMonth(), $date->getDay(),
                $this->hour, $this->minute, $this->second);
        }

        return $date;
    }

    protected function getMonth()
    {
        return $this->month ?: $this->getMonthByName();
    }

    /**
     * @return mixed
     */
    protected function getMonthByName()
    {
        if (!array_key_exists($this->strMonth, static::$monthNameToMonthNumber)) {
            throw new InvalidDateException($this->strMonth);
        }

        return static::$monthNameToMonthNumber[$this->strMonth];
    }
}
