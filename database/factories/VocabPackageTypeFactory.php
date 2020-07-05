<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabPackageType;
use Faker\Generator as Faker;

$factory->define(VocabPackageType::class, function (Faker $faker) {
    return [
        VocabPackageType::FIELD_NAME => $faker->text(10),
    ];
});
