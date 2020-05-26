<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $gender = \App\Support\RuFaker::gender();

    return [
        Employee::FIELD_NAME => \App\Support\RuFaker::name($gender),
        Employee::FIELD_PATRONYMIC => \App\Support\RuFaker::patronymic($gender),
        Employee::FIELD_FAMILY => \App\Support\RuFaker::family($gender),
        Employee::FIELD_HIRED_DATE => $faker->dateTime->format('Y-m-d'),
    ];
});
