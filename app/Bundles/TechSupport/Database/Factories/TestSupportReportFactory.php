<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\TechSupport\Models\TechSupportReport;
use Faker\Generator as Faker;

$factory->define(TechSupportReport::class, function (Faker $faker) {
    return [
        TechSupportReport::FIELD_MESSAGE => $faker->text(),
        TechSupportReport::FIELD_AUTHOR_TITLE => $faker->name(),
        TechSupportReport::FIELD_AUTHOR_CONTACT => $faker->phoneNumber,
        TechSupportReport::FIELD_IP => $faker->ipv4,
        TechSupportReport::FIELD_USER_ID => factory(\App\User::class)->create()->id,
    ];
});
