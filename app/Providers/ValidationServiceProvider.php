<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('default_value', function($attribute, &$value, $parameters, $validator)
        {
            if (empty($value)) {
                $value = $parameters[0];
            }

            return true;
        });
    }
}
