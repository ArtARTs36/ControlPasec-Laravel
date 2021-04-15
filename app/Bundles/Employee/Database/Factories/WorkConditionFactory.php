<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Employee\Models\WorkCondition;
use Faker\Generator as Faker;

$factory->define(WorkCondition::class, function (Faker $faker) {
    return [
        WorkCondition::FIELD_POSITION => $faker->text(25),
        WorkCondition::FIELD_AMOUNT_HOUR => rand(500, 1000),
        WorkCondition::FIELD_RATE => $faker->randomFloat(null, 0.1, 1),
        WorkCondition::FIELD_TAB_NUMBER => $faker->uuid,
        WorkCondition::FIELD_HIRE_DATE => $faker->date(),
    ];
});
