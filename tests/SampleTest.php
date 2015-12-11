<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\NumberToStringConverter;
use Opilo\Farsi\StringCleaner;

class SampleTest
{
    public function sample_1()
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', '2015-09-03');

        $jalaliDate = JalaliDate::fromDateTime($dateTime);

        echo("\n");
        echo($jalaliDate->format('D S M ماه سال X'));
    }

    public function sample_2()
    {
        $jalaliDate = new JalaliDate(1394, 6, 12);
        $dateTime = $jalaliDate->toDateTime();
        echo("\n");
        echo($dateTime->format('Y-m-d'));
        echo("\n");
    }

    public function sample_3()
    {
        echo("\n");
        echo NumberToStringConverter::toString(21034510);
        echo("\n");
    }

    public function sample_4()
    {
        echo("\n");
        echo('نکته‌ی ' . NumberToStringConverter::toOrdinalString(2));
        echo("\n");
    }

    public function sample_5()
    {
        echo(StringCleaner::digitsToFarsi('1394'));
        echo("\n");
        echo(StringCleaner::digitsToEnglish('۱۳۹۴'));
        echo("\n");
        echo(StringCleaner::arabicToFarsi('كيك پي اچ پي چيست؟'));
        echo("\n");
    }

    public function sample_6()
    {
        $jalaliDate = JalaliDate::fromFormat('Y/m/d', '1394/6/20');
        echo("\n");
        echo($jalaliDate->format('D، d M y'));
        echo("\n");
    }
}
