<?php

namespace Opilo\Farsi\Laravel;

use DateTime;
use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\JDateTime;
use Opilo\Farsi\StringCleaner;

class JalaliValidator
{
    protected static $monthNames = [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند',
    ];

    /**
     * @var JalaliDate
     */
    protected static $sampleDate;

    /**
     * @var JDateTime
     */
    protected static $sampleDateTime;

    /**
     * @return JalaliDate
     */
    public static function getSampleDate()
    {
        return static::$sampleDate ?: JalaliDate::fromDateTime(new DateTime());
    }

    /**
     * @param JalaliDate $sampleDate
     */
    public static function setSampleDate(JalaliDate $sampleDate = null)
    {
        static::$sampleDate = $sampleDate;
    }

    /**
     * @return JDateTime
     */
    public static function getSampleDateTime()
    {
        return static::$sampleDateTime ?: JDateTime::fromDateTime(new DateTime());
    }

    /**
     * @param JDateTime $sampleDateTime
     */
    public static function setSampleDateTime(JDateTime $sampleDateTime = null)
    {
        static::$sampleDateTime = $sampleDateTime;
    }

    public function validateJalali($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }

        $format = count($parameters) ? $parameters[0] : 'Y/m/d';

        try {
            JalaliDate::fromFormat($format, $value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function validateJDateTime($attribute, $value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }

        $format = count($parameters) ? $parameters[0] : 'Y/m/d h:i:s';

        try {
            JDateTime::fromFormat($format, $value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function compare($value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }

        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        $baseDate = count($parameters) ?
            JalaliDate::fromFormat($format, $parameters[0]) :
            JalaliDate::fromDateTime(new DateTime());

        try {
            return JalaliDate::fromFormat($format, $value)->toInteger() - $baseDate->toInteger();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function compareJDateTime($value, $parameters)
    {
        if (!is_string($value)) {
            return false;
        }

        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d h:i:s';

        $baseDate = count($parameters) ?
            JDateTime::fromFormat($format, $parameters[0]) :
            JDateTime::fromDateTime(new DateTime());

        try {
            $jDateTime = JDateTime::fromFormat($format, $value);
            $dateCompare = $jDateTime->toInteger() - $baseDate->toInteger();
            if ($dateCompare) {
                return $dateCompare;
            }

            return $jDateTime->secondsSinceMidnight() - $baseDate->secondsSinceMidnight();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateAfter($attribute, $value, $parameters)
    {
        $diff = $this->compare($value, $parameters);

        return $diff !== false && $diff > 0;
    }

    public function validateJDateTimeAfter($attribute, $value, $parameters)
    {
        $diff = $this->compareJDateTime($value, $parameters);

        return $diff !== false && $diff > 0;
    }

    public function validateBefore($attribute, $value, $parameters)
    {
        $diff = $this->compare($value, $parameters);

        return $diff !== false && $diff < 0;
    }

    public function validateJDateTimeBefore($attribute, $value, $parameters)
    {
        $diff = $this->compareJDateTime($value, $parameters);

        return $diff !== false && $diff < 0;
    }

    protected function getSample($format, $rule)
    {
        $includeTime = !preg_match('/^jalali/', $rule);
        $date = $includeTime ? static::getSampleDateTime() : static::getSampleDate();

        $functions = str_split($format);
        $sample = '';
        $escaped = false;

        foreach ($functions as $function) {
            if ($escaped) {
                $sample .= $function;
                $escaped = false;
            } elseif ($function === '\\') {
                $escaped = true;
            } elseif ($function === 'd' || $function === 'j') {
                $sample .= $date->getDay();
            } elseif ($function === 'z') {
                $sample .= $date->dayOfYear();
            } elseif ($function === 'm' || $function === 'n') {
                $sample .= $date->getMonth();
            } elseif ($function === 'M') {
                $sample .= static::$monthNames[$date->getMonth() - 1];
            } elseif ($function === 'Y') {
                $sample .= $date->getYear();
            } elseif ($function === 'y') {
                $sample .= $date->getYear() % 100;
            } else {
                if ($includeTime) {
                    if ($function === 'h') {
                        $sample .= $date->getHour();
                    } elseif ($function === 'i') {
                        $sample .= $date->getMinute();
                    } elseif ($function === 's') {
                        $sample .= $date->getSecond();
                    } else {
                        $sample .= $function;
                    }
                } else {
                    $sample .= $function;
                }
            }
        }

        return $sample;
    }

    public function replaceJalali($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) ? $parameters[0] : $this->defaultFormat($rule);

        $sample = $this->getSample($format, $rule);
        $faSample = StringCleaner::digitsToFarsi($sample);

        return str_replace([':format', ':sample', ':fa-sample'], [$format, $sample, $faSample], $message);
    }

    public function replaceAfterOrBefore($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : $this->defaultFormat($rule);

        $date = count($parameters) ? $parameters[0] : $this->defaultSampleDate($format, $rule);

        $faDate = StringCleaner::digitsToFarsi($date);

        return str_replace([':date', ':fa-date'], [$date, $faDate], $message);
    }

    protected function defaultFormat($rule)
    {
        return preg_match('/^jalali/', $rule) ? 'Y/m/d' : 'Y/m/d h:i:s';
    }

    /**
     * @param string $format
     * @param string $rule
     *
     * @return string
     */
    protected function defaultSampleDate($format, $rule)
    {
        return preg_match('/^jalali/', $rule)
            ? JalaliDate::fromDateTime(new DateTime())->format($format, false)
            : JDateTime::fromDateTime(new DateTime())->format($format, false);
    }
}
