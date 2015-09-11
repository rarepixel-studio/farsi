<?php

namespace Opilo\Farsi;

use InvalidArgumentException;

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

    /**
     * @param string $format
     * @param string $date
     * @throw InvalidArgumentException
     * @return JalaliDate
     */
    public static function createJalaliFromFormat($format, $date)
    {
        $dateParts = new DateParts();
        $regexp = '';
        $matchCount = 0;
        $escaped = false;
        $functions = str_split($format);
        foreach ($functions as $function) {
            if ($escaped) {
                $regexp .= preg_quote($function);
                $escaped = false;
            } elseif ($function === '\\') {
                $escaped = true;
            } elseif ($function === '.') {
                $regexp .= '.';
            } elseif ($function === '*') {
                $regexp .= '.*';
            } elseif ($function === '/') {
                $regexp .= '\\/';
            } elseif (array_key_exists($function, static::$conversionFunctions)) {
                $f = static::$conversionFunctions[$function];
                $regexp .= '(' . static::$f($dateParts, $matchCount) . ')';
            } else {
                $regexp .= preg_quote($function);
            }
        }

        if ($dateParts->isAmbiguous()) {
            throw new InvalidArgumentException();
        }

        $regexp = "/^$regexp\$/";
        $date = StringCleaner::digitsToEnglish($date);
        if (!preg_match($regexp, $date, $matches)) {
            throw new InvalidArgumentException();
        }
        $dateParts->fillWithMatches($matches);
        return $dateParts->createJalaliDate();
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
}

class DateParts
{
    protected static $defaultCentury = 1300;

    protected static $monthNameToMonthNumber = [
        'فروردین' => 1,
        'اردیبهشت' => 2,
        'خرداد' => 3,
        'تیر' => 4,
        'مرداد' => 5,
        'شهریور' => 6,
        'مهر' => 7,
        'آبان' => 8,
        'آذر' => 9,
        'دی' => 10,
        'بهمن' => 11,
        'اسفند' => 12,
    ];
    public $year;
    public $yearOfCentury;
    public $day;
    public $month;
    public $strMonth;
    public $dayOfYear;

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
    }

    public function createJalaliDate()
    {
        $y = $this->year ?: static::$defaultCentury + $this->yearOfCentury;
        if (!$this->hasNoMonth() && $this->day) {
            return new JalaliDate($y, $this->getMonth(), $this->day);
        }
        $firstDay = new JalaliDate($y, 1, 1);
        return JalaliDate::fromInteger($firstDay->toInteger() - 1 + $this->dayOfYear);
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
        if(! array_key_exists($this->strMonth, static::$monthNameToMonthNumber)) {
            throw new InvalidArgumentException();
        }
        return static::$monthNameToMonthNumber[$this->strMonth];
    }
}