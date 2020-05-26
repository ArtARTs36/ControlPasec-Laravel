<?php

namespace App\Support;

use Faker\Generator;

class RuFaker
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public static $generator;

    public static $products = [
        self::GENDER_MALE => [
            'Мед', 'Карандаш', 'Окно', 'Пластик',
        ],
        self::GENDER_FEMALE => [
            'Вишня', 'Черешня', 'Тумба', 'Ручка', 'Дверь'
        ],
    ];

    public static $colors = [
        self::GENDER_MALE => [
            'Красный', 'Черный', 'Белый', 'Зеленый', 'Оранжевый',
        ],
        self::GENDER_FEMALE => [
            'Красная', 'Черная', 'Белая', 'Зеленая', 'Оранжевая',
        ],
    ];

    public static function getGenerator(): Generator
    {
        if (static::$generator === null) {
            static::$generator = \Faker\Factory::create('ru_RU');
        }

        return static::$generator;
    }

    public static function product(bool $withColor = true)
    {
        $gender = static::gender();

        $product = static::$products[$gender][array_rand(static::$products[$gender])];

        return $product . (($withColor === true) ? ' ' . self::color($gender) : '');
    }

    public static function color($gender = self::GENDER_MALE)
    {
        return static::$colors[$gender][array_rand(static::$colors[$gender])];
    }

    public static function gender(): int
    {
        return rand(static::GENDER_MALE, static::GENDER_FEMALE);
    }

    public static function fio(): array
    {
        $fullName = static::getGenerator()->name;

        return explode(' ', $fullName);
    }
}
