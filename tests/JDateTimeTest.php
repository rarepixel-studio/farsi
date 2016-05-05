<?php

namespace OpiloTest\Farsi;

use DateTime;
use Opilo\Farsi\DateConverter;
use Opilo\Farsi\JDateTime;
use PHPUnit_Framework_TestCase;

class JDateTimeTest extends PHPUnit_Framework_TestCase
{
    public function provideInvalidJDateTime()
    {
        return [
            [1395, 1, 16, -1, 1, 2],
            [1395, 1, 16, 24, 1, 2],
            [1395, 1, 16, 1, -1, 2],
            [1395, 1, 16, 1, 60, 2],
            [1395, 1, 16, 1, 6, -2],
            [1395, 1, 16, 1, 6, 60],
            [1395, 13, 16, 1, 6, 60],
        ];
    }

    /**
     * @expectedException \Opilo\Farsi\InvalidDateException
     *
     * @dataProvider provideInvalidJDateTime
     */
    public function test_invalid_j_date_time($y, $m, $d, $h, $i, $s)
    {
        new JDateTime($y, $m, $d, $h, $i, $s);
    }

    public function provideDateTimeJDateTime()
    {
        return [
            [new DateTime('2016-05-05 12:48:50'), new JDateTime(1395, 2, 16, 12, 48, 50)],
            [new DateTime('2016-05-06 13:04:05'), new JDateTime(1395, 2, 17, 13, 4, 5)],
            [new DateTime('2016-05-06 0:0:0'), new JDateTime(1395, 2, 17, 0, 0, 0)],
        ];
    }

    /**
     * @param DateTime $dateTime
     * @param JDateTime $jDateTime
     *
     * @dataProvider provideDateTimeJDateTime
     */
    public function test_j_date_time_from_date_time(DateTime $dateTime, JDateTime $jDateTime)
    {
        $this->assertEquals($jDateTime, JDateTime::fromDateTime($dateTime));
        $this->assertEquals($jDateTime, DateConverter::dateTimeToJDateTime($dateTime));
    }
}
