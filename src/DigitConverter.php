<?php
namespace Opilo\Farsi;

class DigitConverter
{
    protected static $enNumbers = [0 ,1, 2, 3, 4, 5, 6, 7, 8, 9];
    protected static $faNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /**
     * Replace all the occurrences of English digits with Farsi digits
     * @param string $input
     * @return string
     */
    public static function toFarsi($input)
    {
        return str_replace(static::$enNumbers, static::$faNumbers, $input);
    }

    /**
     * Replace all the occurrences of Farsi digits with English digits
     * @param string $input
     * @return string
     */
    public static function toEnglish($input)
    {
        return str_replace(static::$faNumbers, static::$enNumbers, $input);
    }
}