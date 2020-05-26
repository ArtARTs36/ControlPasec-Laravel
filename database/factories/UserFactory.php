<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $gender = rand(1, 2);

    $names = \App\Support\RuFaker::fio();

    return [
        'name' => $names[1],
        'patronymic' => $names[2],
        'family' => $names[0],
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'position' => $faker->userName,
        'is_active' => $faker->boolean,
        'gender' => $gender,
        'avatar_url' => \App\Support\Avatar::byGender($gender),
        'about_me' => $faker->text(250),
    ];
});
