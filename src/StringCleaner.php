<?php

namespace Opilo\Farsi;

/**
 * Class StringCleaner
 * @package Opilo\Farsi
 *
 * Functions in this class is a helper for common issues that Farsi developers face with when dealing with
 * 1. Farsi and English digits
 * 2. Arabic characters in Farsi strings (caused by using non-standard keyboards or pressing the wrong key)
 */
class StringCleaner
{
    protected static $enNumbers = ['0' ,'1', '2', '3', '4', '5', '6', '7', '8', '9'];
    protected static $faNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    protected static $ar2fa = [
        ['ي', 'ك'],
        ['ی', 'ک'],
    ];

    /**
     * Replace all the occurrences of English digits with Farsi digits
     * @param string $input
     * @return string
     */
    public static function digitsToFarsi($input)
    {
        return str_replace(static::$enNumbers, static::$faNumbers, $input);
    }

    /**
     * Clean the input string from arabic characters
     * @param string $input
     * @return string
     */
    public static function arabicToFarsi($input)
    {
        return str_replace(static::$ar2fa[0], static::$ar2fa[1], $input);
    }

    /**
     * Replace all the occurrences of Farsi digits with English digits
     * @param string $input
     * @return string
     */
    public static function digitsToEnglish($input)
    {
        return str_replace(static::$faNumbers, static::$enNumbers, $input);
    }
}