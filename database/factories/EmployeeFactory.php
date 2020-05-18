<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        Employee::FIELD_NAME => $faker->text(20),
        Employee::FIELD_PATRONYMIC => $faker->domainName,
        Employee::FIELD_FAMILY => $faker->lastName,
        Employee::FIELD_HIRED_DATE => $faker->dateTime->format('Y-m-d'),
    ];
});
