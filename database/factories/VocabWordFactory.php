<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabWord;
use Faker\Generator as Faker;

$factory->define(VocabWord::class, function (Faker $faker) {
    $fields = $faker->boolean ?
        VocabWord::getSingularFields() :
        array_merge(VocabWord::getSingularFields(), VocabWord::getPluralFields());

    $data = [];

    foreach ($fields as $field) {
        $data[$field] = $faker->text(10);
    }

    return $data;
});
