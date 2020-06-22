<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use Faker\Generator as Faker;

$factory->define(ExternalNews::class, function (Faker $faker, $params) {
    $data = [
        ExternalNews::FIELD_TITLE => $faker->text(80),
        ExternalNews::FIELD_DESCRIPTION => $faker->text,
        ExternalNews::FIELD_PUB_DATE => $faker->dateTime(),
        ExternalNews::FIELD_LINK => $faker->url,
    ];

    if (empty($params[ExternalNews::FIELD_SOURCE_ID])) {
        $data[ExternalNews::FIELD_SOURCE_ID] = ExternalNewsSource::query()->inRandomOrder()->first()->id;
    }

    return $data;
});
