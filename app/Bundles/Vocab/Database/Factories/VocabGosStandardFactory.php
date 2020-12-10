<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Bundles\Vocab\Models\VocabGosStandard::class, function (Faker $faker) {
    return [
        \App\Bundles\Vocab\Models\VocabGosStandard::FIELD_NAME => $faker->word,
        \App\Bundles\Vocab\Models\VocabGosStandard::FIELD_DATE_INTRODUCTION => $faker->dateTime,
        \App\Bundles\Vocab\Models\VocabGosStandard::FIELD_IS_ACTIVE => $faker->boolean,
        \App\Bundles\Vocab\Models\VocabGosStandard::FIELD_DESCRIPTION => $faker->word,
    ];
});
