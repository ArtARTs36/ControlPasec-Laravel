<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Employee\Models\Employee;
use App\Support\RuFaker;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Employee::class, function (Faker $faker) {
    $gender = RuFaker::gender();

    return [
        Employee::FIELD_NAME => RuFaker::name($gender),
        Employee::FIELD_PATRONYMIC => RuFaker::patronymic($gender),
        Employee::FIELD_FAMILY => RuFaker::family($gender),
        Employee::FIELD_HIRED_DATE => $faker->dateTime->format('Y-m-d'),
        Employee::FIELD_HOLIDAY => $faker->dateTime->format('Y-m-d'),
        Employee::FIELD_INSURANCE_NUMBER => RuFaker::insuranceNumber(),
    ];
});
