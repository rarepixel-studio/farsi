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

    public function provideToJalaliMap()
    {
        return [
            ['2015-07-31', 1394, 5, 9],
            ['2015-03-21', 1394, 1, 1],
            ['2015-04-19', 1394, 1, 30],
            ['2015-04-20', 1394, 1, 31],
            ['2015-09-22', 1394, 6, 31],
            ['2015-10-21', 1394, 7, 29],
            ['2015-11-21', 1394, 8, 30],
            ['2016-03-19', 1394, 12, 29],

            ['1996-3-20', 1375, 1, 1],
            ['1996-3-21', 1375, 1, 2],
            ['1996-04-18', 1375, 1, 30],
            ['1996-04-19', 1375, 1, 31],
            ['1996-09-21', 1375, 6, 31],
            ['1996-10-20', 1375, 7, 29],
            ['1996-11-20', 1375, 8, 30],
            ['1997-03-19', 1375, 12, 29],
            ['1997-03-20', 1375, 12, 30],

            ['1991-03-21', 1370, 1, 1],
//            ['2015-07-31', 1370, 1, 31],
//            ['2015-07-31', 1370, 1, 30],
//            ['2015-07-31', 1370, 6, 31],
//            ['2015-07-31', 1370, 7, 29],
//            ['2015-07-31', 1370, 8, 30],
//            ['2015-07-31', 1370, 12, 29],
//            ['2015-07-31', 1370, 12, 30],
//
//            ['1997-03-21', 1376, 1, 1],
//            ['2015-07-31', 1376, 1, 31],
//            ['2015-07-31', 1376, 1, 30],
//            ['2015-07-31', 1376, 6, 31],
//            ['2015-07-31', 1376, 7, 29],
//            ['2015-07-31', 1376, 8, 30],
//            ['2015-07-31', 1376, 12, 29],
//
//            ['2015-07-31', 1374, 1, 1],
//            ['2015-07-31', 1374, 1, 31],
//            ['2015-07-31', 1374, 1, 30],
//            ['2015-07-31', 1374, 6, 31],
//            ['2015-07-31', 1374, 7, 29],
//            ['2015-07-31', 1374, 8, 30],
//            ['2015-07-31', 1374, 12, 29],
//
//            ['2015-07-31', 1379, 1, 1],
//            ['2015-07-31', 1379, 1, 31],
//            ['2015-07-31', 1379, 1, 30],
//            ['2015-07-31', 1379, 6, 31],
//            ['2015-07-31', 1379, 7, 29],
//            ['2015-07-31', 1379, 8, 30],
//            ['2015-07-31', 1379, 12, 29],
//            ['2015-07-31', 1379, 12, 30],

        ];
    }


    /**
     * @dataProvider provideToJalaliMap
     */
    public function test_convert_DateTime_to_JalaliDate($date, $y, $m, $d)
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);
        $jalali = $this->converter->dateTimeToJalali($dateTime);
        $this->assertEquals(new JalaliDate($y, $m, $d), $jalali);
    }
}