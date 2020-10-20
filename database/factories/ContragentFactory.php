<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contragent;
use App\Support\RuFaker;
use Faker\Generator as Faker;

$factory->define(Contragent::class, function (Faker $faker, $params) {
    $name = RuFaker::name();

    return [
        Contragent::FIELD_TITLE => $name,
        Contragent::FIELD_FULL_TITLE => $name,
        Contragent::FIELD_FULL_TITLE_WITH_OPF => RuFaker::withOpf($name),
        Contragent::FIELD_INN => rand(11111111, 99999999999),
        Contragent::FIELD_KPP => rand(11111111, 99999999999),
        Contragent::FIELD_OGRN => rand(11111111, 99999999999),
        Contragent::FIELD_OKATO => rand(11111111, 99999999999),
        Contragent::FIELD_OKTMO => rand(11111111, 99999999999),
        Contragent::FIELD_OKVED => rand(11111111, 99999999999),
        Contragent::FIELD_OKVED_TYPE => rand(11, 99),
        Contragent::FIELD_ADDRESS => RuFaker::getGenerator()->address,
        Contragent::FIELD_ADDRESS_POSTAL => rand(111111, 999999),
        Contragent::FIELD_STATUS => 0,
    ];
});
