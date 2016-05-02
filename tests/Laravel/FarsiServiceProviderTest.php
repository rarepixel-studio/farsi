<?php

namespace OpiloTest\Farsi\Laravel;

use DateTime;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Opilo\Farsi\Laravel\JalaliValidator;
use Opilo\Farsi\JalaliDate;
use Opilo\Farsi\StringCleaner;
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

        $this->factory->extend('jalali', function ($attribute, $value, $parameter) use ($validator) {
            return  $validator->validateJalali($attribute, $value, $parameter);
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

    public function test_validating_Jalali_fails_with_english_locale()
    {
        JalaliValidator::setSampleDate(new JalaliDate(1395, 1, 1));

        $validator = $this->factory->make(
            [
                'birth_date'      => '1394/9/32',
                'graduation_date' => '1394-9-32',
            ],
            [
                'birth_date'      => 'required|jalali',
                'graduation_date' => 'required|jalali:Y-m-d',
            ]
        );

        $this->assertEquals([
            'birth_date' => [
                'Please provide a valid birth date according to the Jalali Calendar.',
            ],
            'graduation_date' => [
                'The graduation date does not match Jalali Date format Y-m-d. A sample valid Jalali Date would be "1395-1-1".',
            ],
        ], $validator->messages()->toArray());

        JalaliValidator::setSampleDate();
    }

    public function test_validating_Jalali_fails_with_farsi_locale()
    {
        $this->translator->setLocale('fa');

        JalaliValidator::setSampleDate(new JalaliDate(1395, 2, 13));

        $validator = $this->factory->make(
            [
                'graduation_date' => 'foo',
                'birth_date'      => 'bar',
            ],
            [
                'graduation_date' => 'required|jalali:y/M/d',
                'birth_date'      => 'required|jalali',
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

    public function test_jalali_after_or_before_replacer_is_applied_with_date()
    {
        $this->translator->setLocale('fa');

        $faNow = '۱۳۹۴/۹/۱۴';
        $validator = $this->factory->make(
            [
                'birth_date' => 'garbage',
            ],
            [
                'birth_date' => "required|jalali_after:$faNow|jalali_before:$faNow",
            ]
        );

        $this->assertTrue($validator->fails());

        $this->assertEquals([
            'birth_date' => [
                "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر بعد از $faNow باشد.",
                "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر قبل از $faNow باشد.",
            ],
        ], $validator->messages()->toArray());
    }

    public function test_jalali_after_or_before_replacer_is_applied_with_date_and_format()
    {
        $now = '1394-9-15';
        $faNow = StringCleaner::digitsToFarsi($now);
        $validator = $this->factory->make(
            [
                'graduation_date' => 'garbage',
            ],
            [
                'graduation_date' => "required|jalali_after:$now,Y-m-d|jalali_before:$now,Y-m-d",
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
}
