<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Product\Models\Product;
use App\Bundles\Vocab\Models\SizeOfUnit;
use App\Bundles\Vocab\Models\VocabCurrency;
use App\Bundles\Vocab\Models\VocabGosStandard;
use App\Bundles\Vocab\Models\VocabPackageType;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        Product::FIELD_NAME => $faker->word,
        Product::FIELD_NAME_FOR_DOCUMENT => $faker->word,
        Product::FIELD_SIZE => $faker->randomNumber(),
        Product::FIELD_PRICE => $faker->randomNumber(),
        Product::FIELD_SIZE_OF_UNIT_ID => factory(SizeOfUnit::class)->create()->id,
        Product::FIELD_CURRENCY_ID => factory(VocabCurrency::class)->create()->id,
        Product::FIELD_QUANTITY_UNIT_ID => factory(VocabQuantityUnit::class)->create()->id,
        Product::FIELD_PACKAGE_TYPE_ID => factory(VocabPackageType::class)->create()->id,
        Product::FIELD_GOS_STANDARD_ID => factory(VocabGosStandard::class)->create()->id,
    ];
});
