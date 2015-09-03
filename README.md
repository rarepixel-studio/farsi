# Opilo Farsi Tools
This package provides Farsi tools for PHP developers.
## Jalali (Higri Shamsi) Date
The `JalaliDate` class represents Iranian calendar. It calculates leap years based on data referenced in [this wiki page](https://fa.wikipedia.org/wiki/گاه‌شماری_رسمی_ایران).

The following code shows how you can convert a `DateTime` object into a `JalaliDate` one and then print it according to a desired format.
All you need is using methods in `DateConverter` and take a look at `JalaliFormatter::$conversionFunctions` array to know what to pass to `JalaliDate::format()` function as format string.

```php
use Opilo\Farsi\DateConverter;

$dateTime = \DateTime::createFromFormat('Y-m-d', '2015-09-03');

$jalaliDate = DateConverter::dateTimeToJalali($dateTime);

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

Note that if you try to construct an invalid `JalaliDate`, an `InvalidArgumentException` will be thrown.

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

## License

The Opilo Farsi package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)