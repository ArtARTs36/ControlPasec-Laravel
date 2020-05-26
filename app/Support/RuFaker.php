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

    public static $names = [
        self::GENDER_MALE => [
            'Артем', 'Виктор', 'Владимир', 'Сергей', 'Иван', 'Степан', 'Андрей', 'Роман',
        ],
        self::GENDER_FEMALE => [
            'Людмила', 'Юлия', 'Ольга', 'Наталья', 'Светлана', 'Ксения', 'Елена',
        ],
    ];

    public static $patronymics = [
        self::GENDER_MALE => [
            'Артемович', 'Викторович', 'Владимирович', 'Сергеевич', 'Иванович', 'Степанович', 'Андреевич', 'Романович',
        ],
        self::GENDER_FEMALE => [
            'Артемновна', 'Викторовна', 'Владимировна', 'Сергеевна', 'Ивановна', 'Степановна', 'Андреевна', 'Романовна',
        ],
    ];

    public static $families = [
        self::GENDER_MALE => [
            'Украинский', 'Сердюков', 'Иванов', 'Сергеев', 'Степанов', 'Семенов', 'Козленко',
        ],
        self::GENDER_FEMALE => [
            'Украинская', 'Сердюкова', 'Иванова', 'Сергеева', 'Степанова', 'Семенова', 'Козленко',
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

        $product = static::ofArray(static::$products[$gender]);

        return $product . (($withColor === true) ? ' ' . self::color($gender) : '');
    }

    public static function color($gender = self::GENDER_MALE)
    {
        return static::ofArray(static::$colors[static::prepareGender($gender)]);
    }

    public static function gender(): int
    {
        return rand(static::GENDER_MALE, static::GENDER_FEMALE);
    }

    public static function fio(int $gender = null): string
    {
        $gender = static::prepareGender($gender);

        return implode(' ', [
            static::family($gender),
            static::name($gender),
            static::patronymic($gender),
        ]);
    }

    public static function family(int $gender = null): string
    {
        return static::ofArray(static::$families[static::prepareGender($gender)]);
    }

    public static function name(int $gender = null): string
    {
        return static::ofArray(static::$names[static::prepareGender($gender)]);
    }

    public static function patronymic(int $gender = null): string
    {
        return static::ofArray(static::$patronymics[static::prepareGender($gender)]);
    }

    private static function prepareGender(int $value = null)
    {
        return (in_array($value, [static::GENDER_MALE, static::GENDER_FEMALE])) ? $value : static::gender();
    }

    private static function ofArray(array $array)
    {
        return $array[array_rand($array)];
    }
}
