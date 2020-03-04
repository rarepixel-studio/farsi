<?php

namespace OpiloTest\Farsi;

use DateInterval;
use DatePeriod;
use jDateTime;
use Opilo\Farsi\JalaliDate;
use PHPUnit\Framework\TestCase;

/**
 * @test
 * @group brute_force
 */
class SallarJdatetimeTest extends TestCase
{
    public function brute_force_test_against_sallar_jdatetime()
    {
        $firstDate = (new JalaliDate(1343, 1, 1))->toDateTime();
        $lastDate = (new JalaliDate(1473, 12, 30))->toDateTime();
        $interval = DateInterval::createFromDateString('1 day');
        /** @var DatePeriod|\DateTime[] $period */
        $period = new DatePeriod($firstDate, $interval, $lastDate);
        foreach ($period as $date) {
            $oJDate = JalaliDate::fromDateTime($date)->format('Y-m-d', false);
            $sJDate = jDateTime::date('Y-m-d', $date->getTimestamp(), false, true);
            $this->assertEquals($oJDate, $sJDate);
        }
    }

    public function test_prev_mismatch_event()
    {
        $gDate = \DateTime::createFromFormat('Y-m-d', '1963-03-21');
        $oDate = JalaliDate::fromDateTime($gDate)->format('Y-m-d', false);
        $sDate = (jDateTime::date('Y-m-d', $gDate->getTimestamp(), false, true));
        $this->assertEquals('1341-12-30', $oDate);
        $this->assertEquals('1342-01-01', $sDate);
    }

    public function test_next_mismatch_event()
    {
        $gDate = \DateTime::createFromFormat('Y-m-d', '2095-3-20');
        $oDate = JalaliDate::fromDateTime($gDate)->format('Y-m-d', false);
        $sDate = (jDateTime::date('Y-m-d', $gDate->getTimestamp(), false, true));
        $this->assertEquals('1473-12-30', $oDate);
        $this->assertEquals('1474-01-01', $sDate);
    }
}
