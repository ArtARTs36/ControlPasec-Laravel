<?php

namespace App\Services\Service;

class OrfoService
{
    const DAY_OF_WEEK = [
        '',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
        'Воскресение'
    ];

    static private function getLiterals($withReplaceSpace = false)
    {
        $literals = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        if ($withReplaceSpace === true) {
            $literals[' '] = '_';
        }

        return $literals;
    }

    public static function transLit($string, $withReplaceSpace = false)
    {
        return strtr($string, self::getLiterals($withReplaceSpace));
    }

    public static function backTransLit($string)
    {
        $literals = array_flip(self::getLiterals());

        $correctLiterals = [
            'Yo' => 'Ё',
            'yo' => 'ё',
            'e' => 'е',
            'Е' => 'Е',
            "'" => 'ь'
        ];

        $literals = array_merge($literals, $correctLiterals);

        return strtr($string, $literals);
    }

    /**
     * Заполнить массив днями по номеру
     * @param array $array
     * @return array
     */
    public static function fillArrayDayOfWeekByNumber($array)
    {
        foreach ($array as $key => &$value) {
            if (isset(self::DAY_OF_WEEK[$value])) {
                $value = self::DAY_OF_WEEK[$value];
            }
        }

        return $array;
    }

    /**
     * @param \DateTime $date
     * @return string
     */
    public static function getDayOfWeek($date)
    {
        return self::DAY_OF_WEEK[$date->format('N')];
    }
}
