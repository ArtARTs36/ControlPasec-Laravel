<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use Faker\Generator as Faker;

$factory->define(ExternalNewsSource::class, function (Faker $faker) {
    return [
        ExternalNewsSource::FIELD_NAME => $faker->word,
        ExternalNewsSource::FIELD_LINK => $faker->url,
    ];
});
