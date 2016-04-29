<?php

namespace Opilo\Farsi;

class JalaliFormatter
{
    protected static $conversionFunctions = [
        'd' => 'get2DigitDay',
        'j' => 'getDay',
        'S' => 'getDayString',
        'z' => 'getDayOfYear',
        'm' => 'get2DigitMonth',
        'M' => 'getMonthName',
        'n' => 'getMonth',
        't' => 'getNumberOfDaysInMonth',
        'L' => 'isLeapYear',
        'Y' => 'getYear',
        'y' => 'get2DigitYear',
        'X' => 'getYearString',
        'x' => 'get2DigitYearString',
        'w' => 'getWeekDay',
        'D' => 'getWeekDayName',
        'W' => 'getWeekOfYearString',
        'V' => 'getWeekOfYear',
    ];

    protected static $timeConversionFunctions = [
        'a' => 'getLowerMeridiem',
        'A' => 'getHigherMeridiem',
        'b' => 'getFarsiMeridiem',
        'B' => 'getLongFarsiMeridiem',
        'g' => 'get12Hour',
        'G' => 'get24Hour',
        'h' => 'get2Digit12Hour',
        'H' => 'get2Digit24Hour',
        'i' => 'getMinutes',
        's' => 'getSeconds',
        'o' => 'get12HourString',
        'p' => 'get24HourString',
        'q' => 'getMinuteString',
        'r' => 'getSecondString',
    ];

    protected static $monthNames = [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند',
    ];

    protected static $weekDays = [
        'شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه',
    ];

    /**
     * @param JalaliDate|JDateTime $date
     * @param string     $format
     * @param bool       $farsiDigits whether to convert english digits to farsi
     *
     * @return string
     */
    public static function jalaliToString(JalaliDate $date, $format, $farsiDigits = true)
    {
        $output = '';
        $functions = str_split($format);
        $escaped = false;
        foreach ($functions as $function) {
            if ($escaped) {
                $output .= $function;
                $escaped = false;
            } elseif ($function === '\\') {
                $escaped = true;
            } elseif (array_key_exists($function, static::$conversionFunctions)) {
                $f = static::$conversionFunctions[$function];
                $output .= static::$f($date);
            } elseif ($date instanceof JDateTime && array_key_exists($function, static::$timeConversionFunctions)) {
                $f = static::$timeConversionFunctions[$function];
                $output .= static::$f($date);
            } else {
                $output .= $function;
            }
        }

        if ($farsiDigits) {
            $output = StringCleaner::digitsToFarsi($output);
        }

        return $output;
    }

    protected static function get2DigitDay(JalaliDate $date)
    {
        $day = static::getDay($date);

        return strlen($day) == 1 ? '0' . $day : $day;
    }

    protected static function getDay(JalaliDate $date)
    {
        return (string) $date->getDay();
    }

    protected static function getDayString(JalaliDate $date)
    {
        return NumberToStringConverter::toOrdinalString($date->getDay());
    }

    protected static function getDayOfYear(JalaliDate $date)
    {
        return (string) $date->dayOfYear();
    }

    protected static function get2DigitMonth(JalaliDate $date)
    {
        $month = static::getMonth($date);

        return strlen($month) == 1 ? '0' . $month : $month;
    }

    protected static function getMonthName(JalaliDate $date)
    {
        return static::$monthNames[$date->getMonth() - 1];
    }

    protected static function getMonth(JalaliDate $date)
    {
        return (string) $date->getMonth();
    }

    protected static function getNumberOfDaysInMonth(JalaliDate $date)
    {
        return (string) JalaliDate::getDaysInMonth($date->getMonth());
    }

    protected static function isLeapYear(JalaliDate $date)
    {
        return $date->isInLeapYear() ? '1' : '0';
    }

    protected static function getYear(JalaliDate $date)
    {
        return (string) $date->getYear();
    }

    protected static function get2DigitYear(JalaliDate $date)
    {
        $year = $date->getYear() % 100;

        return strlen($year) == 1 ? '0' . $year : $year;
    }

    protected static function getYearString(JalaliDate $date)
    {
        return NumberToStringConverter::toString($date->getYear());
    }

    protected static function get2DigitYearString(JalaliDate $date)
    {
        return NumberToStringConverter::toString($date->getYear() % 100);
    }

    protected static function getWeekDay(JalaliDate $date)
    {
        return (string) $date->getWeekDay();
    }

    protected static function getWeekDayName(JalaliDate $date)
    {
        return static::$weekDays[$date->getWeekDay()];
    }

    protected static function getWeekOfYearString(JalaliDate $date)
    {
        return NumberToStringConverter::toOrdinalString($date->getWeekOfYear());
    }

    protected static function getWeekOfYear(JalaliDate $date)
    {
        return (string) $date->getWeekOfYear();
    }

    protected static function getLowerMeridiem(JDateTime $date)
    {
        return $date->getHour() < 12 ? 'am' : 'pm';
    }

    protected static function getHigherMeridiem(JDateTime $date)
    {
        return strtoupper(static::getLowerMeridiem($date));
    }

    protected static function getFarsiMeridiem(JDateTime $date)
    {
        return static::getLowerMeridiem($date) == 'am' ? 'ق.ظ' : 'ب.ظ';
    }

    protected static function getLongFarsiMeridiem(JDateTime $date)
    {
        return static::getLowerMeridiem($date) == 'am' ? 'قبل از ظهر' : 'بعد از ظهر';
    }

    protected static function get12Hour(JDateTime $date)
    {
        return (string) (($date->getHour() % 12) ?: 12);
    }

    protected static function get24Hour(JDateTime $date)
    {
        return (string) $date->getHour();
    }

    protected static function get2Digit12Hour(JDateTime $date)
    {
        $hour = static::get12Hour($date);
        return strlen($hour) == 1 ? '0' . $hour : $hour;
    }

    protected static function get2Digit24Hour(JDateTime $date)
    {
        $hour = static::get24Hour($date);
        return strlen($hour) == 1 ? '0' . $hour : $hour;
    }

    protected static function getMinutes(JDateTime $date)
    {
        $minute = (string)$date->getMinute();
        return strlen($minute) == 1 ? '0' . $minute : $minute;
    }

    protected static function getSeconds(JDateTime $date)
    {
        $second = (string)$date->getSecond();
        return strlen($second) == 1 ? '0' . $second : $second;
    }

    protected static function get12HourString(JDateTime $date)
    {
        return NumberToStringConverter::toString(static::get12Hour($date));
    }

    protected static function get24HourString(JDateTime $date)
    {
        return NumberToStringConverter::toString($date->getHour());
    }

    protected static function getMinuteString(JDateTime $date)
    {
        return NumberToStringConverter::toString($date->getMinute());
    }

    protected static function getSecondString(JDateTime $date)
    {
        return NumberToStringConverter::toString($date->getSecond());
    }
}
