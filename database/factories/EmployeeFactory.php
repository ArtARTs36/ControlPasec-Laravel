<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'patronymic' => $faker->domainName,
        'family' => $faker->lastName,
    ];
});
