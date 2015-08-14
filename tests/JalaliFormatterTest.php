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
        $this->assertEquals($output, JalaliFormatter::JalaliToString(new JalaliDate($year, $month, $day), $format));
    }
}