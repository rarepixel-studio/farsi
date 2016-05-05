<?php

namespace OpiloTest\Farsi\Laravel;

use DateTime;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Opilo\Farsi\JDateTime;
use Opilo\Farsi\Laravel\JalaliValidator;
use Opilo\Farsi\JalaliDate;
use PHPUnit_Framework_TestCase;

class FarsiServiceProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var Translator
     */
    private $translator;

    public function setUp()
    {
        parent::setUp();
        $this->translator = new Translator(new FileLoader(new Filesystem(), __DIR__ . '/../../src/Laravel/sample-lang'), 'en');
        $this->translator->setLocale('en');
        $this->factory = new Factory($this->translator);

        $validator = new JalaliValidator();
        JalaliValidator::setSampleDateTime();
        JalaliValidator::setSampleDate();
        $this->registerJalaliRules($validator);
        $this->registerJDateTimeRules($validator);
    }

    /**
     * @param JalaliValidator $validator
     */
    private function registerJalaliRules(JalaliValidator $validator)
    {
        $this->factory->extend('jalali', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateJalali($attribute, $value, $parameter);
        });

        $this->factory->extend('jalali_after', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateAfter($attribute, $value, $parameter);
        });

        $this->factory->extend('jalali_before', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateBefore($attribute, $value, $parameter);
        });

        $this->factory->replacer('jalali', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceJalali($message, $attribute, $rule, $parameter);
        });

        $this->factory->replacer('jalali_after', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceAfterOrBefore($message, $attribute, $rule, $parameter);
        });

        $this->factory->replacer('jalali_before', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceAfterOrBefore($message, $attribute, $rule, $parameter);
        });
    }

    /**
     * @param JalaliValidator $validator
     */
    private function registerJDateTimeRules(JalaliValidator $validator)
    {
        $this->factory->extend('jdatetime', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateJDateTime($attribute, $value, $parameter);
        });

        $this->factory->extend('jdatetime_after', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateJDateTimeAfter($attribute, $value, $parameter);
        });

        $this->factory->extend('jdatetime_before', function ($attribute, $value, $parameter) use ($validator) {
            return $validator->validateJDateTimeBefore($attribute, $value, $parameter);
        });

        $this->factory->replacer('jdatetime', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceJalali($message, $attribute, $rule, $parameter);
        });

        $this->factory->replacer('jdatetime_after', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceAfterOrBefore($message, $attribute, $rule, $parameter);
        });

        $this->factory->replacer('jdatetime_before', function ($message, $attribute, $rule, $parameter) use ($validator) {
            return $validator->replaceAfterOrBefore($message, $attribute, $rule, $parameter);
        });
    }

    public function test_validation_rules_pass()
    {
        $validator = $this->factory->make(
            [
                'j_date_1' => '1394/9/12',
                'j_date_2' => '۱۲ آذر ۱۳۹۴',
                'j_date_3' => '1394-9-12 13:21:44',
            ],
            [
                'j_date_1' => 'required|jalali|jalali_after:1394/9/1|jalali_before|jalali_before:1394/12/12',
                'j_date_2' => 'required|jalali:d M Y|jalali_after:۱ آذر ۱۳۹۴,d M Y|jalali_before:۲۹ اسفند ۱۳۹۴,d M Y',
                'j_date_3' => 'required|jalali:Y-m-d *',
            ]
        );
        $this->assertTrue($validator->passes());
    }

    public function test_j_date_time_validation_rules_pass()
    {
        $validator = $this->factory->make(
            [
                'j_date_1' => '1395/02/16 12:55:42',
                'j_date_2' => '1394-9-12 13:21',
            ],
            [
                'j_date_1' => 'required|jdatetime|jdatetime_after:"1395/2/16 12:55:41"|jdatetime_before:"1395/2/17 12:56:00"',
                'j_date_2' => 'required|jdatetime:"Y-m-d h:i"|jdatetime_after:"1394-9-12 13:20","Y-m-d h:i"',
            ]
        );
        $this->assertTrue($validator->passes());
    }

    public function test_validating_Jalali_fails_with_english_locale()
    {
        JalaliValidator::setSampleDate(new JalaliDate(1395, 1, 1));
        JalaliValidator::setSampleDateTime(new JDateTime(1395, 1, 1, 1, 1, 1));

        $validator = $this->factory->make(
            [
                'birth_date'      => '1394/9/32',
                'graduation_date' => '1394-9-32',
                'start_time'      => ['foo'],
            ],
            [
                'birth_date'      => 'required|jalali',
                'graduation_date' => 'required|jalali:Y-m-d',
                'start_time'      => 'jdatetime',
            ]
        );

        $this->assertEquals([
            'birth_date' => [
                'Please provide a valid birth date according to the Jalali Calendar.',
            ],
            'graduation_date' => [
                'The graduation date does not match Jalali Date format Y-m-d. A sample valid Jalali Date would be "1395-1-1".',
            ],
            'start_time' => [
                'The start time does not match Jalali date-time format Y/m/d h:i:s. A sample valid Jalali date-time would be "1395/1/1 1:1:1".',
            ],
        ], $validator->messages()->toArray());

        JalaliValidator::setSampleDate();
    }

    public function test_validating_Jalali_fails_with_farsi_locale()
    {
        $this->translator->setLocale('fa');

        JalaliValidator::setSampleDate(new JalaliDate(1395, 2, 13));
        JalaliValidator::setSampleDateTime(new JDateTime(1395, 2, 13, 4, 5, 6));

        $validator = $this->factory->make(
            [
                'graduation_date' => 'foo',
                'birth_date'      => 'bar',
                'start_time'      => ['baz'],
            ],
            [
                'graduation_date' => 'required|jalali:y/M/d',
                'birth_date'      => 'required|jalali',
                'start_time'      => 'jdatetime|jdatetime:"Y/m/d h:i"|jdatetime_after:"1400/11/12 13:14","Y/m/d h:i"',
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertEquals([
            'graduation_date' => [
                'graduation date وارد شده تاریخ شمسی معتبری طبق فرمت y/M/d نیست (مثال معتبر: ۹۵/اردیبهشت/۱۳).',
            ],
            'birth_date' => [
                'تاریخ تولد وارد شده تاریخ شمسی معتبری طبق فرمت Y/m/d نیست (مثال معتبر: ۱۳۹۵/۲/۱۳).',
            ],
            'start_time' => [
                'start time وارد شده زمان معتبری طبق فرمت Y/m/d h:i:s نیست (مثال معتبر: ۱۳۹۵/۲/۱۳ ۴:۵:۶).',
                'start time وارد شده زمان معتبری طبق فرمت Y/m/d h:i نیست (مثال معتبر: ۱۳۹۵/۲/۱۳ ۴:۵).',
                'start time وارد شده باید زمان معتبری بعد از ۱۴۰۰/۱۱/۱۲ ۱۳:۱۴ باشد.',
            ],
        ], $validator->messages()->toArray());

        JalaliValidator::setSampleDate();
    }

    public function test_jalali_after_or_before_replacer_is_applied_with_no_parameter()
    {
        $now = JalaliDate::fromDateTime(new DateTime())->format('Y/m/d', false);
        $validator = $this->factory->make(
            [
                'graduation_date' => 'garbage',
            ],
            [
                'graduation_date' => 'required|jalali_after|jalali_before',
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertEquals([
            'graduation_date' => [
                "The graduation date must be a Jalali date after $now.",
                "The graduation date must be a Jalali date before $now.",
            ],
        ], $validator->messages()->toArray());
    }

    public function test_jdatetime_after_or_before_replacer_is_applied_with_no_parameter()
    {
        JalaliValidator::setSampleDateTime(new JDateTime(1395, 2, 17, 15, 30, 40));
        $validator = $this->factory->make(
            [
                'start_time' => 'garbage',
            ],
            [
                'start_time' => 'required|jdatetime|jdatetime_before',
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertStringStartsWith('The start time must be a Jalali date-time before', $validator->messages()->toArray()['start_time'][1]);
        $this->assertEquals(
            'The start time does not match Jalali date-time format Y/m/d h:i:s. A sample valid Jalali date-time would be "1395/2/17 15:30:40".',
            $validator->messages()->toArray()['start_time'][0]);
    }

    public function test_jalali_after_or_before_replacer_is_applied_with_date()
    {
        $this->translator->setLocale('fa');

        $faNow = '۱۳۹۴/۹/۱۴';
        $faTime = '۱۳۹۴/۹/۱۴ ۱۵:۱۶:۱۷';

        $validator = $this->factory->make(
            [
                'birth_date' => 'garbage',
                'start_time' => 'garbage',
            ],
            [
                'birth_date' => "required|jalali_after:$faNow|jalali_before:$faNow",
                'start_time' => "required|jdatetime_after:$faTime",
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertEquals([
            'birth_date' => [
                "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر بعد از $faNow باشد.",
                "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر قبل از $faNow باشد.",
            ],
            'start_time' => [
                "start time وارد شده باید زمان معتبری بعد از $faTime باشد.",
            ],
        ], $validator->messages()->toArray());
    }

    public function test_jalali_after_or_before_replacer_is_applied_with_date_and_format()
    {
        $now = '1394-9-15';
        $time = '1394-9-15 16:17:18';
        $validator = $this->factory->make(
            [
                'graduation_date' => 'garbage',
                'start_time'      => 'garbage',
            ],
            [
                'graduation_date' => "required|jalali_after:$now,Y-m-d|jalali_before:$now,Y-m-d",
                'start_time'      => "required|jdatetime_after:$time,Y-m-d h:i:s|jdatetime:$time,Y-m-d h:i:s",
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertEquals([
            'graduation_date' => [
                "The graduation date must be a Jalali date after $now.",
                "The graduation date must be a Jalali date before $now.",
            ],
            'start_time' => [
                "The start time must be a Jalali date-time after $time.",
                "The start time does not match Jalali date-time format 1394-9-15 16:17:18. A sample valid Jalali date-time would be \"$time\".",
            ],
        ], $validator->messages()->toArray());
    }
}
