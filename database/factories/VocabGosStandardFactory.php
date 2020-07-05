<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabGosStandard;
use Faker\Generator as Faker;

$factory->define(VocabGosStandard::class, function (Faker $faker) {
    return [
        VocabGosStandard::FIELD_NAME => $faker->text(10),
        VocabGosStandard::FIELD_DESCRIPTION => $faker->text(80),
        VocabGosStandard::FIELD_IS_ACTIVE => $faker->boolean,
        VocabGosStandard::FIELD_DATE_INTRODUCTION => $faker->date(),
    ];
});
