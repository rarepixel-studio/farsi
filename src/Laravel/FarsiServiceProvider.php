<?php

namespace Opilo\Farsi\Laravel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class FarsiServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->registerJalaliRules();

        $this->registerJDateTimeRules();
    }

    protected function registerJalaliRules()
    {
        Validator::extend('jalali', JalaliValidator::class . '@validateJalali');

        Validator::extend('jalali_after', JalaliValidator::class . '@validateAfter');

        Validator::extend('jalali_before', JalaliValidator::class . '@validateBefore');

        Validator::replacer('jalali', JalaliValidator::class . '@replaceJalali');

        Validator::replacer('jalali_after', JalaliValidator::class . '@replaceAfterOrBefore');

        Validator::replacer('jalali_before', JalaliValidator::class . '@replaceAfterOrBefore');
    }

    protected function registerJDateTimeRules()
    {
        Validator::extend('jdatetime', JalaliValidator::class . '@validateJDateTime');

        Validator::extend('jdatetime_after', JalaliValidator::class . '@validateJDateTimeAfter');

        Validator::extend('jdatetime_before', JalaliValidator::class . '@validateJDateTimeBefore');

        Validator::replacer('jdatetime', JalaliValidator::class . '@replaceJalali');

        Validator::replacer('jdatetime_after', JalaliValidator::class . '@replaceAfterOrBefore');

        Validator::replacer('jdatetime_before', JalaliValidator::class . '@replaceAfterOrBefore');
    }
}
