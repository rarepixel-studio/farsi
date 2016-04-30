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
     * @param JalaliDate|JDateTime $jDate
     *
     * @return DateTime
     */
    public static function jalaliToDateTime(JalaliDate $jDate)
    {
        $firstDay = (new GeorgianDate(622, 3, 22))->toInteger();
        $nDays = $jDate->toInteger() + $firstDay - 1;
        $georgian = GeorgianDate::fromInteger($nDays);

        $dateTime = static::georgianToDateTime($georgian);
        if ($jDate instanceof JDateTime) {
            $dateTime->setTime($jDate->getHour(), $jDate->getMinute(), $jDate->getSecond());
        }
        return $dateTime;
    }

    /**
     * @param GeorgianDate $gDate
     *
     * @return DateTime
     */
    public static function georgianToDateTime(GeorgianDate $gDate)
    {
        $date = DateTime::createFromFormat('Y-m-d|', $gDate->getYear() . '-' . $gDate->getMonth() . '-' . $gDate->getDay());

        return $date;
    }
}
