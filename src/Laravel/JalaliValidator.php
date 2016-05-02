<?php

namespace Opilo\Farsi\Laravel;

use DateTime;
use Opilo\Farsi\JalaliDate;
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
     * @return JalaliDate
     */
    public static function getSampleDate()
    {
        return static::$sampleDate ?: JalaliDate::fromDateTime(new DateTime());
    }

    /**
     * @param JalaliDate|null $sampleDate
     */
    public static function setSampleDate(JalaliDate $sampleDate = null)
    {
        static::$sampleDate = $sampleDate;
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

    public function validateAfter($attribute, $value, $parameters)
    {
        $diff = $this->compare($value, $parameters);

        return $diff !== false && $diff > 0;
    }

    public function validateBefore($attribute, $value, $parameters)
    {
        $diff = $this->compare($value, $parameters);

        return $diff !== false && $diff < 0;
    }

    protected function getSample($format)
    {
        $date = static::getSampleDate();

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
                $sample .= $function;
            }
        }

        return $sample;
    }

    public function replaceJalali($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) ? $parameters[0] : 'Y/m/d';

        $sample = $this->getSample($format);
        $faSample = StringCleaner::digitsToFarsi($sample);

        return str_replace([':format', ':sample', ':fa-sample'], [$format, $sample, $faSample], $message);
    }

    public function replaceAfterOrBefore($message, $attribute, $rule, $parameters)
    {
        $format = count($parameters) > 1 ? $parameters[1] : 'Y/m/d';

        $date = count($parameters) ? $parameters[0] : JalaliDate::fromDateTime(new DateTime())->format($format, false);

        $faDate = StringCleaner::digitsToFarsi($date);

        return str_replace([':date', ':fa-date'], [$date, $faDate], $message);
    }
}
