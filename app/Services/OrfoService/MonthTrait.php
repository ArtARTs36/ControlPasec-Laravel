<?php

namespace App\Services\OrfoService;

trait MonthTrait
{
    static $months = [
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
            'Декабрь'
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
            'Декабря'
        ],
    ];

    public static function getMonthById($id, $dec = 'nom', $lowerCase = false)
    {
        $month = self::$months[$dec][$id];

        return ($lowerCase === true) ? lcfirst($month) : $month;
    }

    public static function getMonth(\DateTime $dateTime, $dec = 'nom', $lowerCase = false)
    {
        return self::getMonthById($dateTime->format('n'), $dec, $lowerCase);
    }
}
