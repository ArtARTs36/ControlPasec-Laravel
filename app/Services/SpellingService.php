<?php

namespace App\Services;

use App\Services\SpellingService\DayTrait;
use App\Services\SpellingService\LiteralTrait;
use App\Services\SpellingService\MonthTrait;

/**
 * Class SpellingService
 * Сервис орфографии
 */
class SpellingService
{
    use DayTrait, MonthTrait, LiteralTrait;

    /**
     * Транслит русских символов к английским
     * @param string $string
     * @param bool $withReplaceSpace
     * @return string
     */
    public static function rusSymbolsToEng(string $string, bool $withReplaceSpace = false): string
    {
        return strtr($string, self::getLiterals($withReplaceSpace));
    }

    /**
     * Транслит английских символов к русским
     * @param string $string
     * @return string
     */
    public static function engSymbolsToRus(string $string): string
    {
        $literals = array_flip(self::getLiterals());

        $correctLiterals = [
            'Yo' => 'Ё',
            'yo' => 'ё',
            'e' => 'е',
            'Е' => 'Е',
            "'" => 'ь'
        ];

        return strtr($string, array_merge($literals, $correctLiterals));
    }

    /**
     * Заполнить массив днями по номеру
     * @param array $array
     * @return array
     */
    public static function fillArrayDayOfWeekByNumber(array $array): array
    {
        foreach ($array as $key => &$value) {
            $value = self::getDayOfWeek($value);
        }

        return $array;
    }
}
