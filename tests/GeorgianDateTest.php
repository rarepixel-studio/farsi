<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\GeorgianDate;
use PHPUnit_Framework_TestCase;

class GeorgianDateTest extends PHPUnit_Framework_TestCase
{
    public function test_day_of_year()
    {
        $this->assertSame(1, (new GeorgianDate(2000, 1, 1))->dayOfYear());
        $this->assertSame(366, (new GeorgianDate(2000, 12, 31))->dayOfYear());
        $this->assertSame(60, (new GeorgianDate(2000, 2, 29))->dayOfYear());
        $this->assertSame(90, (new GeorgianDate(2000, 3, 30))->dayOfYear());

        $this->assertSame(365, (new GeorgianDate(2100, 12, 31))->dayOfYear());
        $this->assertSame(59, (new GeorgianDate(2100, 2, 28))->dayOfYear());
        $this->assertSame(89, (new GeorgianDate(2100, 3, 30))->dayOfYear());
    }

    public function test_leap_years()
    {
        $this->assertTrue(GeorgianDate::isLeapYear(2000));
        $this->assertFalse(GeorgianDate::isLeapYear(1100));
        $this->assertFalse(GeorgianDate::isLeapYear(1101));
        $this->assertFalse(GeorgianDate::isLeapYear(1102));
        $this->assertFalse(GeorgianDate::isLeapYear(1103));
        $this->assertTrue(GeorgianDate::isLeapYear(1104));
    }

    /**
     * @throws \Exception
     * @test
     * @group brute_force
     */
    public function brute_force_test_from_and_to_integer()
    {
        for ($i = 1; $i < 1039828; $i++) {
            $this->assertEquals($i, GeorgianDate::fromInteger($i)->toInteger());
        }
    }
}