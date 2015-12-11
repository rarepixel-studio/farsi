<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\JalaliParser;
use PHPUnit_Framework_TestCase;

class JalaliParserTest extends PHPUnit_Framework_TestCase
{
    public function provideFormats()
    {
        return [
            ['Y/m/d', '۱۳۹۴/۱۲/۲۰', 1394, 12, 20],
            ['Y/m/d', '1394/12/20', 1394, 12, 20],
            ['Y/m/d', '1394/02/03', 1394, 2, 3],
            ['Y/m/d', '1394/1/2', 1394, 1, 2],
            ['y/m/d', '94/6/1', 1394, 6, 1],

            ['Y-d-m', '1394-20-12', 1394, 12, 20],
            ['Y.m.d', '1394:02:03', 1394, 2, 3],
            ['Y*m*d', '1394..1..2', 1394, 1, 2],
            ['y\ym\md\d', '94y6m1d', 1394, 6, 1],
            ['14y m d', '1494 6 1', 1394, 6, 1],

            ['Y/n/j', '1394/12/20', 1394, 12, 20],
            ['Y/n/j', '1394/02/03', 1394, 2, 3],
            ['Y/n/j', '1394/1/2', 1394, 1, 2],
            ['y/n/j', '94/6/1', 1394, 6, 1],

            ['Y/n/j z', '1394/12/20 1', 1394, 12, 20],
            ['Y-z', '1394-34', 1394, 2, 3],

            ['Y/M/d', '1394/فروردین/20', 1394, 1, 20],
            ['Y/M/d', '1394/اردیبهشت/20', 1394, 2, 20],
            ['Y/M/d', '1394/خرداد/20', 1394, 3, 20],
            ['Y/M/d', '1394/تیر/20', 1394, 4, 20],
            ['Y/M/d', '1394/مرداد/20', 1394, 5, 20],
            ['Y/M/d', '1394/شهریور/20', 1394, 6, 20],
            ['Y/M/d', '1394/مهر/20', 1394, 7, 20],
            ['Y/M/d', '1394/آبان/20', 1394, 8, 20],
            ['Y/M/d', '1394/آذر/20', 1394, 9, 20],
            ['Y/M/d', '1394/دی/20', 1394, 10, 20],
            ['Y/M/d', '1394/بهمن/20', 1394, 11, 20],
            ['Y/M/d', '1394/اسفند/20', 1394, 12, 20],
        ];
    }
    /**
     * @param $format
     * @param $date
     * @param $y
     * @param $m
     * @param $d
     * @dataProvider provideFormats
     */
    public function test_format_string_to_JalaliDate($format, $date, $y, $m, $d)
    {
        $j1 = JalaliParser::createJalaliFromFormat($format, $date);
        $j2 = new JalaliDate($y, $m, $d);
        $this->assertEquals($j1, $j2);
    }
}
