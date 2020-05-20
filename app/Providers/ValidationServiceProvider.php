<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('default_value', function ($attribute, &$value, $parameters, $validator) {
            if (empty($value)) {
                $value = $parameters[0];
            }

            return true;
        });

        Validator::extend('not_exists', function ($attribute, $value, $tableData) {
            list($table, $field) = $tableData;

            if (null === DB::table($table)->where($field, $value)->first()) {
                return true;
            }

            return false;
        });

        Validator::extend('double', function ($attribute, $value) {
            return (double) $value == $value;
        });
    }
}
