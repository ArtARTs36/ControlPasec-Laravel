<?php

namespace App\Services;

use App\Parsers\MorpherParser\MorpherParser;
use App\Models\Vocab\VocabWord;

class WordService
{
    /**
     * @param array|string[] $words
     */
    public static function checkVocabs(array $words)
    {
        foreach ($words as $word) {
            if (null !== static::getDeclensions($word)) {
                continue;
            }

            MorpherParser::findDeclensions($word);
        }
    }

    /**
     * Получить склонения
     *
     * @param string $word
     * @return VocabWord|null
     */
    public static function getDeclensions(string $word): ?VocabWord
    {
        return VocabWord::where('nominative', $word)->first();
    }
}
