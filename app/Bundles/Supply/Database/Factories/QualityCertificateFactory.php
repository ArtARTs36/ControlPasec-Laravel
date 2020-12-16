<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Supply\Models\QualityCertificate;
use App\Bundles\Supply\Models\Supply;
use Faker\Generator as Faker;

$factory->define(QualityCertificate::class, function (Faker $faker, array $params) {
    $data = [
        QualityCertificate::FIELD_ORDER_NUMBER => $faker->randomNumber(),
    ];

    if (empty($params[QualityCertificate::FIELD_SUPPLY_ID])) {
        $data[QualityCertificate::FIELD_SUPPLY_ID] = factory(Supply::class)->create()->id;
    }

    return $data;
});
