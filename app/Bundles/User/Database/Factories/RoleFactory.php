<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        Role::FIELD_IS_ALLOWED_FOR_SIGN_UP => true,
        Role::FIELD_NAME => $faker->word,
        Role::FIELD_TITLE => $faker->word,
    ];
});
