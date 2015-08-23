<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\NumberToStringConverter;
use PHPUnit_Framework_TestCase;

class NumberToStringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var NumberToStringConverter
     */
    private $converter;

    public function setUp()
    {
        $this->converter = new NumberToStringConverter();
    }

    public function provider()
    {
        return [
            [0, 'صفر'],
            [1, 'یک'],
            [2, 'دو'],
            [3, 'سه'],
            [4, 'چهار'],
            [5, 'پنج'],
            [6, 'شش'],
            [7, 'هفت'],
            [8, 'هشت'],
            [9, 'نه'],
            [10, 'ده'],
            [11, 'یازده'],
            [12, 'دوازده'],
            [13, 'سیزده'],
            [14, 'چهارده'],
            [15, 'پانزده'],
            [16, 'شانزده'],
            [17, 'هفده'],
            [18, 'هجده'],
            [19, 'نوزده'],
            [20, 'بیست'],
            [30, 'سی'],
            [40, 'چهل'],
            [50, 'پنجاه'],
            [60, 'شصت'],
            [70, 'هفتاد'],
            [80, 'هشتاد'],
            [90, 'نود'],
            [100, 'یکصد'],
            [200, 'دویست'],
            [300, 'سیصد'],
            [400, 'چهارصد'],
            [500, 'پانصد'],
            [600, 'ششصد'],
            [700, 'هفتصد'],
            [800, 'هشتصد'],
            [900, 'نهصد'],
            [1000, 'یک هزار'],
            [2000, 'دو هزار'],
            [1000000, 'یک میلیون'],
            [10000000, 'ده میلیون'],
            [100000000, 'یکصد میلیون'],
            [1000000000, 'یک میلیارد'],
            [123, 'یکصد و بیست و سه'],
            [1234, 'یک هزار و دویست و سی و چهار'],
            [12345, 'دوازده هزار و سیصد و چهل و پنج'],
            [123456, 'یکصد و بیست و سه هزار و چهارصد و پنجاه و شش'],
            [1234567, 'یک میلیون و دویست و سی و چهار هزار و پانصد و شصت و هفت'],
            [12345678, 'دوازده میلیون و سیصد و چهل و پنج هزار و ششصد و هفتاد و هشت'],
            [123456789, 'یکصد و بیست و سه میلیون و چهارصد و پنجاه و شش هزار و هفتصد و هشتاد و نه'],
            [1234567890, 'یک میلیارد و دویست و سی و چهار میلیون و پانصد و شصت و هفت هزار و هشتصد و نود'],
            [21234567890, 'بیست و یک میلیارد و دویست و سی و چهار میلیون و پانصد و شصت و هفت هزار و هشتصد و نود'],
            [321234567890, 'سیصد و بیست و یک میلیارد و دویست و سی و چهار میلیون و پانصد و شصت و هفت هزار و هشتصد و نود'],
        ];
    }

    public function ordinalProvider()
    {
        return [
            [1, 'یکم'],
            [5, 'پنجم'],
            [10, 'دهم'],
            [33, 'سی و سوم'],
            [19, 'نوزدهم'],
            [110, 'یکصد و دهم'],
            [2000, 'دو هزارم'],
        ];
    }

    /**
     * @param $intNum
     * @param $strNum
     * @dataProvider ordinalProvider
     */
    public function testNumbersToOrdinalStrings($intNum, $strNum)
    {
        $this->assertEquals($strNum, $this->converter->toOrdinalString($intNum));
    }

    /**
     * @dataProvider provider
     * @param $intNum
     * @param $strNum
     */
    public function testNumbersToString($intNum, $strNum)
    {
        $this->assertEquals($strNum, $this->converter->toString($intNum));
        if($intNum) {
            $this->assertEquals('منفی ' . $strNum, $this->converter->toString(-$intNum));
        }
    }
}