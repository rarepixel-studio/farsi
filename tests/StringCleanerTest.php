<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\StringCleaner;
use PHPUnit\Framework\TestCase;

class StringCleanerTest extends TestCase
{
    /**
     * @var StringCleaner
     */
    private $cleaner;

    public function setUp() : void
    {
        parent::setUp();
        $this->cleaner = new StringCleaner();
    }

    public function test_convert_digits_to_Farsi()
    {
        $this->assertEquals('۰۹۱۳۴۱۰۷', $this->cleaner->digitsToFarsi('09134107'));
        $this->assertEquals('۰۹۱۳۴۱۰۷', $this->cleaner->digitsToFarsi('091341۰7'));
        $this->assertEquals('۰۹۱۳۴۱۰۷abcd', $this->cleaner->digitsToFarsi('091341۰7abcd'));
    }

    public function test_convert_Arabic_to_Farsi()
    {
        $this->assertEquals('یک', $this->cleaner->arabicToFarsi('يك'));
    }

    public function test_convert_digits_to_English()
    {
        $this->assertEquals('09134107', $this->cleaner->digitsToEnglish('۰۹۱۳۴۱۰۷'));
        $this->assertEquals('09134107', $this->cleaner->digitsToEnglish('۰۹۱۳۴۱0۷'));
        $this->assertEquals('09134107abcd', $this->cleaner->digitsToEnglish('۰۹۱۳۴۱0۷abcd'));
    }
}
