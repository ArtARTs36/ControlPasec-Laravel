<?php

namespace App\Services;

use App\Parsers\MorpherParser\MorpherParser;
use App\Models\Vocab\VocabWord;

class WordService
{
    public static function checkVocabs($words)
    {
        foreach ($words as $word) {
            if (null !== VocabWord::where('nominative', $word)->first()) {
                continue;
            }

            MorpherParser::findDeclensions($word);
        }
    }
}
