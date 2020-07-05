<?php

namespace App\Bundles\Vocab\Services;

use App\Parsers\MorpherParser\MorpherParser;
use App\Bundles\Vocab\Models\VocabWord;

final class WordService
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
        return VocabWord::query()
            ->where(VocabWord::FIELD_NOMINATIVE, $word)
            ->first();
    }
}
