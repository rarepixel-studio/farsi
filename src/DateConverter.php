<?php

namespace Opilo\Farsi;

use DateTime;

class DateConverter
{
    /**
     * Converts a DateTime object to corresponding GeorgianDate object.
     *
     * @param DateTime $dateTime
     *
     * @return GeorgianDate
     */
    public static function dateTimeToGeorgian(DateTime $dateTime)
    {
        $date = $dateTime->format('Y-m-d');
        preg_match('/(.*)-(.*)-(.*)/', $date, $matches);

        return new GeorgianDate((int) $matches[1], (int) $matches[2], (int) $matches[3]);
    }

    /**
     * Converts a DateTime object to corresponding JalaliDate object.
     *
     * @param DateTime $dateTime
     *
     * @return JalaliDate
     */
    public static function dateTimeToJalali(DateTime $dateTime)
    {
        $georgian = static::dateTimeToGeorgian($dateTime);
        $firstDay = new GeorgianDate(622, 3, 22);

        return JalaliDate::fromInteger($georgian->toInteger() - $firstDay->toInteger() + 1);
    }

    /**
     * @param JalaliDate    $jDate
     * @param DateTime|null $time  to set hours, minutes, seconds, microseconds and timezone. When null is provided for
     *                             $time; hours, minutes, seconds, and microseconds will be reset to 0 and timezone
     *                             will be reset to the default timezone.
     *
     * @return DateTime
     */
    public static function jalaliToDateTime(JalaliDate $jDate, DateTime $time = null)
    {
        $firstDay = (new GeorgianDate(622, 3, 22))->toInteger();
        $nDays = $jDate->toInteger() + $firstDay - 1;
        $georgian = GeorgianDate::fromInteger($nDays);

        return static::georgianToDateTime($georgian, $time);
    }

    /**
     * @param GeorgianDate  $gDate
     * @param DateTime|null $time  to set hours, minutes, seconds, microseconds and timezone. When null is provided for
     *                             $time; hours, minutes, seconds, and microseconds will be reset to 0 and timezone
     *                             will be reset to the default timezone.
     *
     * @return DateTime
     */
    public static function georgianToDateTime(GeorgianDate $gDate, DateTime $time = null)
    {
        $date = DateTime::createFromFormat('Y-m-d|', $gDate->getYear() . '-' . $gDate->getMonth() . '-' . $gDate->getDay());

        if (!is_null($time)) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u e', $date->format('Y-m-d') . $time->format(' H:i:s.u e'));
        }

        return $date;
    }
}
