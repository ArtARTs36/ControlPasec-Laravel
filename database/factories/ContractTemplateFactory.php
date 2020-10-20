<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contract\Models\ContractTemplate;
use Faker\Generator as Faker;

$factory->define(ContractTemplate::class, function (Faker $faker) {
    return [
        ContractTemplate::FIELD_NAME => $faker->title,
        ContractTemplate::FIELD_TITLE => $faker->title,
    ];
});
