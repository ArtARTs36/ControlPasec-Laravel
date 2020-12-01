<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\TechSupport\Models\TechSupportReport;
use App\Bundles\Vocab\Models\VocabWord;
use Faker\Generator as Faker;

$factory->define(VocabWord::class, function (Faker $faker) {
    return [
        VocabWord::FIELD_NOMINATIVE => $faker->word,
        VocabWord::FIELD_DATIVE => $faker->word,
        VocabWord::FIELD_GENITIVE => $faker->word,
        VocabWord::FIELD_PREPOSITIONAL => $faker->word,
        VocabWord::FIELD_INSTRUMENTAL => $faker->word,
    ];
});
