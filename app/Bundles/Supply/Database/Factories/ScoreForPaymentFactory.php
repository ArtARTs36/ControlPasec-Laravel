<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Supply\Models\ScoreForPayment;
use App\Bundles\Supply\Models\Supply;
use Faker\Generator as Faker;

$factory->define(ScoreForPayment::class, function (Faker $faker, array $params) {
    $data = [
        ScoreForPayment::FIELD_DATE => $faker->dateTime,
        ScoreForPayment::FIELD_ORDER_NUMBER => 1,
    ];

    if (empty($params[ScoreForPayment::FIELD_SUPPLY_ID])) {
        $data[ScoreForPayment::FIELD_SUPPLY_ID] = factory(Supply::class)->create()->id;
    }

    return $data;
});
