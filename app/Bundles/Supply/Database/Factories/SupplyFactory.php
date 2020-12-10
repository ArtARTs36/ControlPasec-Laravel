<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Contract;
use App\Models\Supply\Supply;
use Faker\Generator as Faker;

$factory->define(Supply::class, function (Faker $faker) {
    return [
        Supply::FIELD_SUPPLIER_ID => factory(Contragent::class)->create()->id,
        Supply::FIELD_CUSTOMER_ID => factory(Contragent::class)->create()->id,
        Supply::FIELD_PLANNED_DATE => $faker->dateTime,
        Supply::FIELD_EXECUTE_DATE => $faker->dateTime,
        Supply::FIELD_CONTRACT_ID => factory(Contract::class)->create()->id,
    ];
});
