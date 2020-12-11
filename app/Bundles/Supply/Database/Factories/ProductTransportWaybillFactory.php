<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Supply\Models\ProductTransportWaybill;
use App\Bundles\Supply\Models\Supply;
use Faker\Generator as Faker;

$factory->define(ProductTransportWaybill::class, function (Faker $faker, array $params) {
    $data = [
        ProductTransportWaybill::FIELD_DATE => $faker->dateTime,
        ProductTransportWaybill::FIELD_ORDER_NUMBER => 1,
    ];

    if (empty($params[ProductTransportWaybill::FIELD_SUPPLY_ID])) {
        $data[ProductTransportWaybill::FIELD_SUPPLY_ID] = factory(Supply::class)->create()->id;
    }

    return $data;
});
