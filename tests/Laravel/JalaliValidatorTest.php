<?php

namespace OpiloTest\Farsi\Laravel;

use DateTime;
use Opilo\Farsi\Laravel\JalaliValidator;
use Opilo\Farsi\JalaliDate;
use PHPUnit\Framework\TestCase;

class JalaliValidatorTest extends TestCase
{
    /**
     * @var JalaliValidator
     */
    private $validator;

    public function setUp() : void
    {
        $this->validator = new JalaliValidator();
    }

    public function test_validate_jalali_without_parameter()
    {
        $this->assertTrue($this->validator->validateJalali('foo', '1394/9/12', []));
        $this->assertFalse($this->validator->validateJalali('foo', '1394/9/32', []));
        $this->assertFalse($this->validator->validateJalali('foo', ['1394/9/12'], []));
    }

    public function test_validate_jalali_with_parameter()
    {
        $this->assertTrue($this->validator->validateJalali('foo', '1394-9-12', ['Y-m-d']));
        $this->assertTrue($this->validator->validateJalali('foo', '1394/9/12 ', ['Y/m/d ']));
        $this->assertTrue($this->validator->validateJalali('foo', '1394/9/12 12:55:59', ['Y/m/d *:*:*']));

        $this->assertFalse($this->validator->validateJalali('foo', '1394-9-32', ['Y-m-d']));
        $this->assertFalse($this->validator->validateJalali('foo', '1394/9/12', ['Y-m-d']));
        $this->assertFalse($this->validator->validateJalali('foo', '12:55:59', ['Y/m/d *:*:*']));
        $this->assertFalse($this->validator->validateJalali('foo', ['1394/9/12'], ['Y/m/d']));
    }

    public function test_validate_after_without_parameter()
    {
        $now = JalaliDate::fromDateTime(new DateTime());
        $tomorrow = JalaliDate::fromInteger($now->toInteger() + 1)->format('Y/m/d');
        $yesterday = JalaliDate::fromInteger($now->toInteger() - 1)->format('Y/m/d');
        $this->assertTrue($this->validator->validateAfter('foo', $tomorrow, []));
        $this->assertFalse($this->validator->validateAfter('foo', $yesterday, []));
        $this->assertFalse($this->validator->validateAfter('foo', $now->format('Y/m/d'), []));
        $this->assertFalse($this->validator->validateAfter('foo', 'bar', []));
    }

    public function test_validate_after_with_date_but_not_format()
    {
        $now = '1394/9/13';
        $tomorrow = '1394/9/14';
        $yesterday = '1394/9/12';
        $this->assertTrue($this->validator->validateAfter('foo', $tomorrow, [$now]));
        $this->assertFalse($this->validator->validateAfter('foo', $yesterday, [$now]));
        $this->assertFalse($this->validator->validateAfter('foo', $now, [$now]));
        $this->assertFalse($this->validator->validateAfter('foo', 'bar', [$now]));
    }

    public function test_validate_after_with_date_and_format()
    {
        $now = '1394-9-13';
        $tomorrow = '1394-9-14';
        $yesterday = '1394-9-12';
        $this->assertFalse($this->validator->validateBefore('foo', $tomorrow, [$now, 'Y-m-d']));
        $this->assertTrue($this->validator->validateBefore('foo', $yesterday, [$now, 'Y-m-d']));
        $this->assertFalse($this->validator->validateBefore('foo', $now, [$now, 'Y-m-d']));
        $this->assertFalse($this->validator->validateBefore('foo', 'bar', [$now, 'Y-m-d']));
    }

    public function test_validate_before_without_parameter()
    {
        $now = JalaliDate::fromDateTime(new DateTime());
        $tomorrow = JalaliDate::fromInteger($now->toInteger() + 1)->format('Y/m/d');
        $yesterday = JalaliDate::fromInteger($now->toInteger() - 1)->format('Y/m/d');
        $this->assertFalse($this->validator->validateBefore('foo', $tomorrow, []));
        $this->assertTrue($this->validator->validateBefore('foo', $yesterday, []));
        $this->assertFalse($this->validator->validateBefore('foo', $now->format('Y/m/d'), []));
        $this->assertFalse($this->validator->validateBefore('foo', 'bar', []));
        $this->assertFalse($this->validator->validateBefore('foo', ['bar'], []));
    }

    public function test_validate_before_with_date_but_not_format()
    {
        $now = '1394/9/13';
        $tomorrow = '1394/9/14';
        $yesterday = '1394/9/12';
        $this->assertFalse($this->validator->validateBefore('foo', $tomorrow, [$now]));
        $this->assertTrue($this->validator->validateBefore('foo', $yesterday, [$now]));
        $this->assertFalse($this->validator->validateBefore('foo', $now, [$now]));
        $this->assertFalse($this->validator->validateBefore('foo', 'bar', [$now]));
    }

    public function test_validate_before_with_date_and_format()
    {
        $now = '1394-9-13';
        $tomorrow = '1394-9-14';
        $yesterday = '1394-9-12';
        $this->assertFalse($this->validator->validateBefore('foo', $tomorrow, [$now, 'Y-m-d']));
        $this->assertTrue($this->validator->validateBefore('foo', $yesterday, [$now, 'Y-m-d']));
        $this->assertFalse($this->validator->validateBefore('foo', $now, [$now, 'Y-m-d']));
        $this->assertFalse($this->validator->validateBefore('foo', 'bar', [$now, 'Y-m-d']));
    }
}
