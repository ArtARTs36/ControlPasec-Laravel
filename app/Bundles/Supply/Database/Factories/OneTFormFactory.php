<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Supply\Models\OneTForm;
use App\Bundles\Supply\Models\Supply;
use Faker\Generator as Faker;

$factory->define(OneTForm::class, function (Faker $faker, array $params) {
    $data = [
        OneTForm::FIELD_ORDER_NUMBER => 1,
    ];

    if (empty($params[OneTForm::FIELD_SUPPLY_ID])) {
        $data[OneTForm::FIELD_SUPPLY_ID] = factory(Supply::class)->create()->id;
    }

    return $data;
});
