<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Admin\Models\VariableDefinition;
use Faker\Generator as Faker;

$factory->define(VariableDefinition::class, function (Faker $faker) {
    return [
        VariableDefinition::FIELD_NAME => $faker->word,
        VariableDefinition::FIELD_VALUE => $faker->randomNumber(),
        VariableDefinition::FIELD_DESCRIPTION => $faker->word,
    ];
});
