<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Contract;
use App\Bundles\Supply\Models\Supply;
use Faker\Generator as Faker;

$factory->define(Supply::class, function (Faker $faker, array $params = []) {
    return [
        Supply::FIELD_SUPPLIER_ID => empty($params[Supply::FIELD_SUPPLIER_ID]) ?
            factory(Contragent::class)->create()->id : $params[Supply::FIELD_SUPPLIER_ID],

        Supply::FIELD_CUSTOMER_ID => factory(Contragent::class)->create()->id,
        Supply::FIELD_PLANNED_DATE => $faker->dateTime,
        Supply::FIELD_EXECUTE_DATE => $faker->dateTime,
        Supply::FIELD_CONTRACT_ID => factory(Contract::class)->create()->id,
    ];
});
