<?php

namespace App\Services;

use ArtARTs36\RuSpelling\Letter;

/**
 * Class SpellingService
 * Сервис орфографии
 */
class SpellingService
{
    /**
     * Транслит английских символов к русским
     * @param string $string
     * @return string
     */
    public static function engSymbolsToRus(string $string): string
    {
        $literals = array_flip(Letter::MAP_ENG);

        $correctLiterals = [
            'Yo' => 'Ё',
            'yo' => 'ё',
            'e' => 'е',
            'Е' => 'Е',
            "'" => 'ь'
        ];

        return strtr($string, array_merge($literals, $correctLiterals));
    }
}
