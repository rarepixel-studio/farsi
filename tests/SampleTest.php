<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\DateConverter;
use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\NumberToStringConverter;
use Opilo\Farsi\StringCleaner;

class SampleTest
{
    public function sample_1()
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', '2015-09-03');

        $jalaliDate = DateConverter::dateTimeToJalali($dateTime);

        print("\n");
        print ($jalaliDate->format('D S M ماه سال X'));

    }

    public function sample_2()
    {
        $jalaliDate = new JalaliDate(1394, 6, 12);
        $dateTime = $jalaliDate->toDateTime();
        print("\n");
        print($dateTime->format('Y-m-d'));
        print("\n");
    }

    public function sample_3()
    {
        print("\n");
        print NumberToStringConverter::toString(21034510);
        print("\n");
    }

    public function sample_4()
    {
        print("\n");
        print ('نکته‌ی ' . NumberToStringConverter::toOrdinalString(2));
        print("\n");
    }

    public function sample_5()
    {
        print(StringCleaner::digitsToFarsi('1394'));
        print("\n");
        print(StringCleaner::digitsToEnglish('۱۳۹۴'));
        print("\n");
        print(StringCleaner::arabicToFarsi('كيك پي اچ پي چيست؟'));
        print("\n");
    }

}