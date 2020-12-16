<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Landing\Models\FeedBack;
use Faker\Generator as Faker;

$factory->define(FeedBack::class, function (Faker $faker) {
    return [
        FeedBack::FIELD_MESSAGE => $faker->text,
        FeedBack::FIELD_IP => $faker->ipv4,
        FeedBack::FIELD_PEOPLE_EMAIL => $faker->email,
        FeedBack::FIELD_PEOPLE_PHONE => $faker->phoneNumber,
        FeedBack::FIELD_PEOPLE_TITLE => $faker->word,
    ];
});
