<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Contract;
use App\Bundles\Supply\Models\ContractTemplate;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {
    return [
        Contract::FIELD_TITLE => $faker->word,
        Contract::FIELD_CUSTOMER_ID => factory(Contragent::class)->create()->id,
        Contract::FIELD_SUPPLIER_ID => factory(Contragent::class)->create()->id,
        Contract::FIELD_PLANNED_DATE => $faker->dateTime,
        Contract::FIELD_EXECUTED_DATE => $faker->dateTime,
        Contract::FIELD_TEMPLATE_ID => factory(ContractTemplate::class)->create()->id,
    ];
});
