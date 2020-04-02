<?php

namespace App\Services\SpellingService;

trait MonthTrait
{
    public static $months = [
        'nom' => [
            'Январь',
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ],
        'gen' => [
            'Января',
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря',
        ],
    ];

    public static function getMonthNameById(int $id, string $dec = 'nom', bool $lowerCase = false): string
    {
        $month = self::$months[$dec][$id];

        return ($lowerCase === true) ? lcfirst($month) : $month;
    }

    public static function getMonthName(\DateTime $dateTime, string $dec = 'nom', bool $lowerCase = false): string
    {
        return self::getMonthNameById((int) $dateTime->format('n'), $dec, $lowerCase);
    }
}
