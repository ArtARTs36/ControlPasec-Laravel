<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contragent\Models\BankRequisites;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Vocab\Models\VocabBank;
use Faker\Generator as Faker;

$factory->define(BankRequisites::class, function (Faker $faker, array $params = []) {
    $data = [
        BankRequisites::FIELD_SCORE => $faker->bankAccountNumber,
        BankRequisites::FIELD_BANK_ID => factory(VocabBank::class)->create()->id,
    ];

    if (empty($params[BankRequisites::FIELD_CONTRAGENT_ID])) {
        $data[BankRequisites::FIELD_CONTRAGENT_ID] = factory(Contragent::class)->create()->id;
    }

    return $data;
});
