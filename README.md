# Opilo Farsi Tools

[![Build Status](https://travis-ci.org/opilo/farsi.svg)](https://travis-ci.org/opilo/farsi)
[![Latest Stable Version](https://poser.pugx.org/opilo/farsi/v/stable)](https://packagist.org/packages/opilo/farsi)
[![Total Downloads](https://poser.pugx.org/opilo/farsi/downloads)](https://packagist.org/packages/opilo/farsi)
[![Latest Unstable Version](https://poser.pugx.org/opilo/farsi/v/unstable)](https://packagist.org/packages/opilo/farsi)
[![License](https://poser.pugx.org/opilo/farsi/license)](https://packagist.org/packages/opilo/farsi)

This package provides Farsi tools for PHP developers. It also introduce validation facilities specially designed for Laravel developers.

## Jalali (Higri Shamsi) Date
The `JalaliDate` class represents Iranian calendar. It calculates leap years based on data referenced in [this wiki page](https://fa.wikipedia.org/wiki/گاه‌شماری_رسمی_ایران).
According to the tests done in `tests/SallarJdatetimeTest.php`, for years between 1343 and 1473, the leap years in this calendar perfectly match those of `calculated` leap years based on the proposed calculation rules.
But it should be considered that Iranian calendar is based on astronomical observations and, unlike the Georgian, it is not a rule-based calendar.

The following code shows how you can convert a `DateTime` object into a `JalaliDate` one and then print it according to a desired format.
All you need is using `JalaliDate::fromDateTime()` method and take a look at `JalaliFormatter::$conversionFunctions` array to know what to pass to `JalaliDate::format()` function as format string.

```php
use Opilo\Farsi\JalaliDate;

$dateTime = \DateTime::createFromFormat('Y-m-d', '2015-09-03');

$jalaliDate = JalaliDate::fromDateTime($dateTime);

print ($jalaliDate->format('D S M ماه سال X'));
```

And the output will be: **پنج‌شنبه دوازدهم شهریور ماه سال یک هزار و سیصد و نود و چهار**

The following sample code shows how to convert numeric inputs representing a Jalali date into a `JalaliDate` and then convert it into `DateTime`.
This may be helpful if you want to validate user's input Jalali date, and then save the appropriate standard timestamp into database.

```php
use Opilo\Farsi\JalaliDate;

$jalaliDate = new JalaliDate(1394, 6, 12);

$dateTime = $jalaliDate->toDateTime();

print($dateTime->format('Y-m-d'));
```

And the output will be: **2015-09-03**

Conveniently, you can also directly convert an string with a known format into a `JalaliDate`:

```php
use Opilo\Farsi\JalaliDate;

$jalaliDate = JalaliDate::fromFormat('Y/m/d', '1394/6/20');

print($jalaliDate->format('D، d M y'));
```

The output of the code above, is: **جمعه، ۲۰ شهریور ۹۴**

Note that if you try to construct an invalid `JalaliDate`, an `InvalidArgumentException` will be thrown.

### JDateTime class
The `JDateTime` class is an extension of `JalaliDate` class with time (hour, minute, second) support.

## Number to String Converter
If your application is supposed to print financial documents, you probably love this:

```php
use Opilo\Farsi\NumberToStringConverter;

print NumberToStringConverter::toString(21034510);
```
because, this is the output: **بیست و یک میلیون و سی و چهار هزار و پانصد و ده**

And, here is the second note **(نکته‌ی دوم)**:

```php
print ('نکته‌ی ' . NumberToStringConverter::toOrdinalString(2));
```

## String Cleanser
With `StringCleanser` class you can deal with Farsi digits while interacting with the users.
`StringCleanser::arabicToFarsi()` function cleans input Farsi strings out of Arabic characters that commonly presents in standard keywords.

```php
use Opilo\Farsi\StringCleaner;

print(StringCleaner::digitsToFarsi('1394'));
print("\n");

print(StringCleaner::digitsToEnglish('۱۳۹۴'));
print("\n");

print(StringCleaner::arabicToFarsi('كيك پي اچ پي چيست؟'));
print("\n");
```

This will (approximately) output:

    ۱۳۹۴
    1394
    کیک پی اچ پی چیز خاصی نیست

## Jalali Validator For Laravel 4.2 and Laravel 5

### Installation

#### Step 1: Add the Service Provider

Add the provider class to the array of providers in config/app.php file

```php
	'providers' => [
	    ...
        Opilo\Farsi\Laravel\FarsiServiceProvider::class,
	]
```

#### Step 2: Define the Error Messages

You need to define error messages for `jalali`, `jalali_after`, and `jalali_before` rules in validation.php in lang folders. Samples to copy & paste are provided under sample-lang directory of this package.
For example, if your project uses Laravel 5 and your Farsi ranslation are under `resources/lang/fa` directory, copy these lines to `resources/lang/fa/validation.php`:

```php
    'jalali'        => ':attribute وارد شده تاریخ شمسی معتبری طبق فرمت :format نیست (مثال معتبر: :fa-sample).',
    'jalali_after'  => ':attribute وارد شده باید یک تاریخ شمسی معتبر بعد از :date باشد.',
    'jalali_before' => ':attribute وارد شده باید یک تاریخ شمسی معتبر قبل از :date باشد.',
    ...
    //the rest of Farsi translations for validation rules.

    'attributes' => [
        'birth_date' => 'تاریخ تولد',
        ...
        //the rest of Farsi translations for attributes
    ],
    ...
```

### Validation Rules

#### jalali:Y/m/d

Determines if an input is a valid Jalali date with the specified format. The default format is `Y/m/d`.

#### jalali_after:1380/1/1,Y/m/d

Determines if an input is a valid Jalali date with the specified format and it is after a given date. The default format is `Y/m/d` and the default date is today.

#### jalali_before:1395-01-01,Y-m-d

Determines if an input is a valid Jalali date with the specified format and it is before a given date. The default format is `Y/m/d` and the default date is today.

#### jdatetime:"Y/m/d h:i:s"

Determines if an input is a valid Jalali date-time with the specified format. The default format is `Y/m/d h:i:s`.

#### jdatetime_after:"1380/1/1 12:00:00","Y/m/d h:i:s"

Determines if an input is a valid Jalali date-time with the specified format and it is after a given date-time. The default format is `Y/m/d h:i:s` and the default time is now.

#### jdatetime_before:"1395-01-01 h:i","Y-m-d h:i"

Determines if an input is a valid Jalali date-time with the specified format and it is before a given date-time. The default format is `Y/m/d h:i:s` and the default time is now.

### Examples

Thanks to Laravel 5, you may use the mentioned validation rules inside rule() function of your domain specific Request objects.
If that is not an option, you can use the rules, just like any other Laravel rules with codes like the following:

```php
    $v = Validator::make([
            'birth_date' => '1380/01/32',
            'start_time' => '1395/02/16 12:10:00',
        ],
        [
            'birth_date' => 'required|jalali|jalali_before:1381/01/01|jalali_after:1300/01/01,Y/m/d',
            'start_time' => 'required|jdatetime_after:"1395/01/01 00:00:00"|jdatetime_before:"1396/01/01 00:00:00"',
        ]);

    if ($v->fails()) {
        var_dump($v->messages()->toArray());
    }
```

The output of the code above will be:

```php
array(1) {
  ["birth_date"]=>
  array(3) {
    [0]=>
    string(140) "تاریخ تولد وارد شده تاریخ شمسی معتبری طبق فرمت Y/m/d نیست (مثال معتبر: ۱۳۹۴/۹/۱۳)."
    [1]=>
    string(113) "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر قبل از 1381/01/01 باشد."
    [2]=>
    string(113) "تاریخ تولد وارد شده باید یک تاریخ شمسی معتبر بعد از 1300/01/01 باشد."
  }
}
```

## License

The Opilo Farsi package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)