<?php

namespace Opilo\Farsi;

class NumberToStringConverter
{
    private static $strDigit = [
        ['ده', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه', 'صفر'],
        ['', 'ده', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'],
        ['', 'یکصد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد'],
        ['ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده'],
        ['', ' هزار', ' میلیون', ' میلیارد'],
    ];

    private static $negative = 'منفی';

    /**
     * @param int $number
     *
     * @return string e.g.: یک، دو، سه، چهار، ...
     */
    public static function toString($number)
    {
        $number = (int) ($number);
        if (!$number) {
            return static::$strDigit[0][10];
        }

        $signed = false;

        if ($number < 0) {
            $signed = true;
            $number *= -1;
        }

        $strNum = '';
        $strAnd = ' و ';
        $strNumber = [];
        for ($i = 0; $i < 4; $i++) {
            if (($sNumber = ($number % 1000)) != 0) {
                $strNumber[$i] = static::$strDigit[2][(int) ($sNumber / 100)];
                $sNumber %= 100;
                if ((int) ($sNumber / 10) == 1) {
                    if ($strNumber[$i] == '') {
                        $strNumber[$i] = static::$strDigit[3][$sNumber % 10];
                    } else {
                        $strNumber[$i] .= $strAnd . static::$strDigit[3][$sNumber % 10];
                    }
                } elseif ($sNumber != 0) {
                    if ((int) ($sNumber / 10) != 0) {
                        if ($strNumber[$i] == '') {
                            $strNumber[$i] = static::$strDigit[1][(int) ($sNumber / 10)];
                        } else {
                            $strNumber[$i] .= $strAnd . static::$strDigit[1][(int) ($sNumber / 10)];
                        }
                    }
                    $sNumber %= 10;
                    if ($sNumber) {
                        if ($strNumber[$i] == '') {
                            $strNumber[$i] = static::$strDigit[0][$sNumber];
                        } else {
                            $strNumber[$i] .= $strAnd . static::$strDigit[0][$sNumber];
                        }
                    }
                }
                if ($strNumber[$i] != '') {
                    $strNumber[$i] .= static::$strDigit[4][$i];
                    if ($strNum == '') {
                        $strNum = $strNumber[$i];
                    } else {
                        $strNum = ($strNumber[$i] . $strAnd . $strNum);
                    }
                }
            }
            $number = (int) ($number / 1000);
        }

        if ($signed) {
            $strNum = static::$negative . ' ' . $strNum;
        }

        return $strNum;
    }

    /**
     * @param int $number
     *
     * @return string e.g.: یکم، دوم، سوم، چهارم، ...
     */
    public static function toOrdinalString($number)
    {
        $output = static::toString($number);
        $output = preg_replace('/سه$/', 'سو', $output);

        return $output . 'م';
    }
}
