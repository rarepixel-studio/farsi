<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\DigitConverter;
use PHPUnit_Framework_TestCase;

class DigitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DigitConverter
     */
    private $converter;

    public function setUp()
    {
        parent::setUp();
        $this->converter = new DigitConverter();
    }

    public function test_convert_string_to_Farsi()
    {
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲' ,$this->converter->toFarsi('09134107672'));
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲' ,$this->converter->toFarsi('091341۰7672'));
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲abcd' ,$this->converter->toFarsi('091341۰7672abcd'));
    }

    public function test_convert_string_to_English()
    {
        $this->assertEquals('09134107672',$this->converter->toEnglish('۰۹۱۳۴۱۰۷۶۷۲'));
        $this->assertEquals('09134107672' ,$this->converter->toEnglish('۰۹۱۳۴۱0۷۶۷۲'));
        $this->assertEquals('09134107672abcd' ,$this->converter->toEnglish('۰۹۱۳۴۱0۷۶۷۲abcd'));
    }
}