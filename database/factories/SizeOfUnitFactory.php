<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\SizeOfUnit;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use App\Services\SpellingService;
use App\Support\RuFaker;
use Faker\Generator as Faker;

foreach ([SizeOfUnit::class, VocabQuantityUnit::class] as $modelClass) {
    $factory->define($modelClass, function (Faker $faker) {
        $fullName = $faker->text(14);

        $shortName = RuFaker::abbreviationWithOpf($fullName);

        return [
            SizeOfUnit::FIELD_NAME => $fullName,
            SizeOfUnit::FIELD_SHORT_NAME => $shortName,
            SizeOfUnit::FIELD_NAME_EN => $fullName,
            SizeOfUnit::FIELD_SHORT_NAME_EN => SpellingService::rusSymbolsToEng($shortName),
            SizeOfUnit::FIELD_OKEI => rand(1000, 9999),
        ];
    });
}
