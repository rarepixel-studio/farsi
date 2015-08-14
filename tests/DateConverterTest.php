<?php
namespace OpiloTest\Farsi;

use Opilo\Farsi\DateConverter;
use Opilo\Farsi\JalaliDate;

class DateConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateConverter
     */
    private $converter;

    public function setUp()
    {
        parent::setUp();
        $this->converter = new DateConverter();
    }

    public function test_convert_DateTime_to_GeorgianDate()
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', '2000-01-02');
        $georgian = $this->converter->dateTimeToGeorgian($dateTime);
        $this->assertSame($georgian->getYear(), 2000);
        $this->assertSame($georgian->getMonth(), 1);
        $this->assertSame($georgian->getDay(), 2);
    }

    public function _test_convert_DateTime_to_JalaliDate($date, $y, $m, $d)
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);
        $jalali = $this->converter->dateTimeToJalali($dateTime);
        $this->assertEquals(new JalaliDate($y, $m, $d), $jalali);
    }

    public function lastDayOfFiveLeapYearToJalaliDate()
    {
        return [
            ['631-3-21', 9],
            ['1836-3-20', 1214],
            ['1865-3-20', 1243],
            ['1902-3-21', 1280],
            ['1935-3-21', 1313],
            ['1997-3-20', 1375],
            ['2030-3-20', 1408],
            ['2063-3-20', 1441],
            ['2100-3-20', 1478],
        ];
    }

    /**
     * @param $date
     * @param $y
     * @dataProvider lastDayOfFiveLeapYearToJalaliDate
     */
    public function test_convert_last_day_of_five_leap_year_to_JalaliDate($date, $y)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, $y, 12, 30);
    }

    public function daysIn1375()
    {
        return [
            ['1996-3-20', 1, 1],
            ['1996-4-1', 1, 13],
            ['1996-4-19', 1, 31],
            ['1996-5-20', 2, 31],
            ['1996-8-20', 5, 30],
            ['1996-9-21', 6, 31],
            ['1996-9-22', 7, 1],
            ['1996-10-21', 7, 30],
            ['1996-12-20', 9, 30],
            ['1997-1-19', 10, 30],
            ['1997-2-8', 11, 20],
            ['1997-2-19', 12, 1],
            ['1997-3-19', 12, 29],
            ['1997-3-20', 12, 30],
        ];
    }

    /**
     * @param $date
     * @param $m
     * @param $d
     * @dataProvider daysIn1375
     */
    public function test_convert_to_days_in_1375($date, $m, $d)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, 1375, $m, $d);
    }

    public function daysInEarly1370s()
    {
        return [
            ['1992-3-21', 1371, 1, 1],
            ['1992-9-21', 1371, 6, 30],
            ['1993-3-20', 1371, 12, 29],
            ['1993-3-21', 1372, 1, 1],
            ['1993-9-21', 1372, 6, 30],
            ['1994-3-20', 1372, 12, 29],
            ['1994-3-21', 1373, 1, 1],
            ['1994-9-21', 1373, 6, 30],
            ['1995-3-20', 1373, 12, 29],
            ['1995-3-21', 1374, 1, 1],
            ['1995-9-21', 1374, 6, 30],
            ['1996-3-19', 1374, 12, 29],
        ];
    }
    /**
     * @param $date
     * @param $y
     * @param $m
     * @param $d
     * @dataProvider daysInEarly1370s
     */
    public function test_convert_to_days_in_early_1370s($date, $y, $m, $d)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, $y, $m, $d);
    }

    public function daysIn1370()
    {
        return [
            ['1991-3-21', 1, 1],
            ['1991-9-21', 6, 30],
            ['1991-9-22', 6, 31],
            ['1992-3-19', 12, 29],
            ['1992-3-20', 12, 30],
        ];
    }

    /**
     * @param $date
     * @param $m
     * @param $d
     * @dataProvider daysIn1370
     */
    public function test_convert_to_days_in_1370($date, $m, $d)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, 1370, $m, $d);
    }

    public function lastDayInANormalLeapYear()
    {
        return [
            ['2001-3-20', 1379],
            ['2005-3-20', 1383],
            ['2009-3-20', 1387],
            ['2013-3-20', 1391],
            ['2017-3-20', 1395],
            ['2021-3-20', 1399],
            ['2025-3-20', 1403],
        ];
    }

    /**
     * @param $date
     * @param $y
     * @dataProvider lastDayInANormalLeapYear
     */
    public function test_convert_to_the_last_day_in_a_normal_leap_year($date, $y)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, $y, 12, 30);
    }

    public function firstDayInANormalLeapYear()
    {
        return [
            ['2000-3-20', 1379],
            ['2004-3-20', 1383],
            ['2008-3-20', 1387],
            ['2012-3-20', 1391],
            ['2016-3-20', 1395],
            ['2020-3-20', 1399],
            ['2024-3-20', 1403],
        ];
    }

    /**
     * @param $date
     * @param $y
     * @dataProvider firstDayInANormalLeapYear
     */
    public function test_convert_to_the_first_day_in_a_normal_leap_year($date, $y)
    {
        $this->_test_convert_DateTime_to_JalaliDate($date, $y, 1, 1);
    }

    public function test_convert_to_day_1()
    {
        $this->_test_convert_DateTime_to_JalaliDate('622-3-22', 1, 1, 1);
    }

    public function test_convert_to_farthest_supported_day_in_future()
    {
        list($y, $m, $d) = JalaliDate::$farthestSupportedDate;
        $this->_test_convert_DateTime_to_JalaliDate('2100-3-20', $y, $m, $d);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_convert_to_days_after_farthest_supported_day_fails()
    {
        list($y, $m, $d) = JalaliDate::$farthestSupportedDate;
        $this->_test_convert_DateTime_to_JalaliDate('2100-3-21', $y + 1, 1, 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_convert_to_days_before_day_one_fails()
    {
        $this->_test_convert_DateTime_to_JalaliDate('622-3-21', 0, 12, 30);
    }

}