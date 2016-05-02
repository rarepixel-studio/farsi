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
        Validator::extend('jalali', JalaliValidator::class . '@validateJalali');

        Validator::extend('jalali_after', JalaliValidator::class . '@validateAfter');

        Validator::extend('jalali_before', JalaliValidator::class . '@validateBefore');

        Validator::replacer('jalali', JalaliValidator::class . '@replaceJalali');

        Validator::replacer('jalali_after', JalaliValidator::class . '@replaceAfterOrBefore');

        Validator::replacer('jalali_before', JalaliValidator::class . '@replaceAfterOrBefore');
    }
}
