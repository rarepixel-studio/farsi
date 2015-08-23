<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\JalaliFormatter;
use PHPUnit_Framework_TestCase;

class JalaliFormatterTest extends PHPUnit_Framework_TestCase
{
    public function provideSamples()
    {
        return [
            [1394, 5, 23, 'Y/m/d', '1394/05/23'],
            [1394, 5, 23, 'y/M/j', '94/مرداد/23'],
            [1394, 5, 23, 'y/n/j', '94/5/23'],

            [1404, 2, 3, 'Y-m-d', '1404-02-03'],
            [1404, 2, 3, 'y-M-j', '04-اردیبهشت-3'],
            [1404, 2, 3, 'y-n-j', '04-2-3'],

            [1404, 2, 3, 'z', '34'],

            [1375, 2, 3, 'L', '1'],
            [1394, 2, 3, 'L', '0'],

            [1375, 1, 1, 'M-t', 'فروردین-31'],
            [1375, 2, 1, 'M-t', 'اردیبهشت-31'],
            [1375, 3, 1, 'M-t', 'خرداد-31'],
            [1375, 4, 1, 'M-t', 'تیر-31'],
            [1375, 5, 1, 'M-t', 'مرداد-31'],
            [1375, 6, 1, 'M-t', 'شهریور-31'],
            [1375, 7, 1, 'M-t', 'مهر-30'],
            [1375, 8, 1, 'M-t', 'آبان-30'],
            [1375, 9, 1, 'M-t', 'آذر-30'],
            [1375, 10, 1, 'M-t', 'دی-30'],
            [1375, 11, 1, 'M-t', 'بهمن-30'],
            [1375, 12, 1, 'M-t', 'اسفند-29'],

            [1, 1, 1, 'w:D', '6:جمعه'],
            [1394, 5, 24, 'w:D', '0:شنبه'],
            [1395, 5, 3, 'w:D', '1:یک‌شنبه'],
            [1396, 5, 2, 'w:D', '2:دوشنبه'],
            [1397, 5, 2, 'w:D', '3:سه‌شنبه'],
            [1398, 5, 2, 'w:D', '4:چهارشنبه'],
            [1399, 5, 2, 'w:D', '5:پنج‌شنبه'],
            [1400, 5, 1, 'w:D', '6:جمعه'],

            [1394, 5, 30, '\y\e\a\r: Y, \m\o\n\t\h: m, \d\a\y: d', 'year: 1394, month: 05, day: 30'],
            [1394, 5, 30, "\\y\\e\\a\\r: Y, \\m\\o\\n\\t\\h: m, \\d\\a\\y: d", 'year: 1394, month: 05, day: 30'],
        ];
    }

    public function provideFarsiSamples()
    {
        return [
            [1394, 5, 23, 'Y/m/d', '۱۳۹۴/۰۵/۲۳'],
            [1394, 5, 23, 'D S M ماه سال X', 'جمعه بیست و سوم مرداد ماه سال یک هزار و سیصد و نود و چهار'],
            [1394, 5, 23, 'سال x', 'سال نود و چهار'],
            [1394, 5, 23, 'y/M/j', '۹۴/مرداد/۲۳'],
            [1394, 5, 23, 'y/n/j', '۹۴/۵/۲۳'],

            [1404, 2, 3, 'Y-m-d', '۱۴۰۴-۰۲-۰۳'],
            [1404, 2, 3, 'y-M-j', '۰۴-اردیبهشت-۳'],
            [1404, 2, 3, 'y-n-j', '۰۴-۲-۳'],

            [1404, 2, 3, 'z', '۳۴'],

            [1375, 2, 3, 'L', '۱'],
            [1394, 2, 3, 'L', '۰'],

            [1375, 1, 1, 'M-t', 'فروردین-۳۱'],
            [1375, 2, 1, 'M-t', 'اردیبهشت-۳۱'],
            [1375, 3, 1, 'M-t', 'خرداد-۳۱'],
            [1375, 4, 1, 'M-t', 'تیر-۳۱'],
            [1375, 5, 1, 'M-t', 'مرداد-۳۱'],
            [1375, 6, 1, 'M-t', 'شهریور-۳۱'],
            [1375, 7, 1, 'M-t', 'مهر-۳۰'],
            [1375, 8, 1, 'M-t', 'آبان-۳۰'],
            [1375, 9, 1, 'M-t', 'آذر-۳۰'],
            [1375, 10, 1, 'M-t', 'دی-۳۰'],
            [1375, 11, 1, 'M-t', 'بهمن-۳۰'],
            [1375, 12, 1, 'M-t', 'اسفند-۲۹'],

            [1, 1, 1, 'w:D', '۶:جمعه'],
            [1394, 5, 24, 'w:D', '۰:شنبه'],
            [1395, 5, 3, 'w:D', '۱:یک‌شنبه'],
            [1396, 5, 2, 'w:D', '۲:دوشنبه'],
            [1397, 5, 2, 'w:D', '۳:سه‌شنبه'],
            [1398, 5, 2, 'w:D', '۴:چهارشنبه'],
            [1399, 5, 2, 'w:D', '۵:پنج‌شنبه'],
            [1400, 5, 1, 'w:D', '۶:جمعه'],


            [1394, 1, 31, 'هفته‌ی W', 'هفته‌ی پنجم'],
            [1394, 1, 31, 'هفته‌ی V', 'هفته‌ی ۵'],
        ];
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     * @param $format
     * @param $output
     * @dataProvider provideSamples
     */
    public function testJalaliToString($year, $month, $day, $format, $output)
    {
        $this->assertEquals($output, JalaliFormatter::JalaliToString(new JalaliDate($year, $month, $day), $format, false));
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     * @param $format
     * @param $output
     * @dataProvider provideFarsiSamples
     */
    public function testJalaliToFarsiString($year, $month, $day, $format, $output)
    {
        $this->assertEquals($output, JalaliFormatter::JalaliToString(new JalaliDate($year, $month, $day), $format));
    }
}