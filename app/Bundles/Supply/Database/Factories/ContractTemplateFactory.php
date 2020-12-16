<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Contract;
use App\Bundles\Supply\Models\ContractTemplate;
use Faker\Generator as Faker;

$factory->define(ContractTemplate::class, function (Faker $faker) {
    return [
        ContractTemplate::FIELD_TITLE => $faker->word,
        ContractTemplate::FIELD_NAME => $faker->word,
    ];
});
