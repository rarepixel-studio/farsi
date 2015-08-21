<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\StringCleaner;
use PHPUnit_Framework_TestCase;

class StringCleanerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StringCleaner
     */
    private $cleaner;

    public function setUp()
    {
        parent::setUp();
        $this->cleaner = new StringCleaner();
    }

    public function test_convert_digits_to_Farsi()
    {
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲' ,$this->cleaner->digitsToFarsi('09134107672'));
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲' ,$this->cleaner->digitsToFarsi('091341۰7672'));
        $this->assertEquals('۰۹۱۳۴۱۰۷۶۷۲abcd' ,$this->cleaner->digitsToFarsi('091341۰7672abcd'));
    }

    public function test_convert_Arabic_to_Farsi()
    {
        $this->assertEquals('یک', $this->cleaner->arabicToFarsi('يك'));
    }

    public function test_convert_digits_to_English()
    {
        $this->assertEquals('09134107672',$this->cleaner->digitsToEnglish('۰۹۱۳۴۱۰۷۶۷۲'));
        $this->assertEquals('09134107672' ,$this->cleaner->digitsToEnglish('۰۹۱۳۴۱0۷۶۷۲'));
        $this->assertEquals('09134107672abcd' ,$this->cleaner->digitsToEnglish('۰۹۱۳۴۱0۷۶۷۲abcd'));
    }
}