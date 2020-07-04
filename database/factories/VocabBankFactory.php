<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Bundles\Vocab\Models\VocabBank::class, function (Faker $faker) {
    $fullName = $faker->name;

    $shortName = \App\Support\RuFaker::withOpf(
        implode('', array_map(function (string $item) {
            return $item[0];
        }, explode(' ', $fullName)))
    );

    return [
        \App\Bundles\Vocab\Models\VocabBank::FIELD_FULL_NAME => $fullName,
        \App\Bundles\Vocab\Models\VocabBank::FIELD_SHORT_NAME => $shortName,
        \App\Bundles\Vocab\Models\VocabBank::FIELD_SCORE => $faker->bankAccountNumber,
        \App\Bundles\Vocab\Models\VocabBank::FIELD_BIK => $faker->numberBetween(),
    ];
});
