<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $gender = \App\Based\Support\RuFaker::gender();

    return [
        'name' => \App\Based\Support\RuFaker::name($gender),
        'patronymic' => \App\Based\Support\RuFaker::patronymic($gender),
        'family' => \App\Based\Support\RuFaker::family($gender),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'position' => $faker->userName,
        'is_active' => $faker->boolean,
        'gender' => $gender,
        'avatar_url' => \App\Based\Support\Avatar::byGender($gender),
        'about_me' => $faker->text(250),
    ];
});
