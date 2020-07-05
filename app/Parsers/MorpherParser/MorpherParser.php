<?php

namespace App\Parsers\MorpherParser;

use App\Bundles\Vocab\Models\VocabWord;

class MorpherParser extends MorpherSender
{
    public static function findDeclensions($word, $create = true)
    {
        $response = self::getRequest(self::URL_METHOD_DECLENSION, [
            's' => $word,
        ]);

        return ($create === true) ? self::createVocabWordByResponse($word, $response) : $response;
    }

    public static function getTypeWordByResponse($response)
    {
        if (!isset($response['ФИО'])) {
            return VocabWord::TYPE_UNKNOWN;
        }

        foreach ($response['ФИО'] as $type => $value) {
            if (empty($value)) {
                continue;
            }

            switch ($type) {
                case 'Ф':
                    return VocabWord::TYPE_FAMILY;

                case 'И':
                    return VocabWord::TYPE_NAME;

                case 'О':
                    return VocabWord::TYPE_PATRONYMIC;
            }
        }

        return VocabWord::TYPE_UNKNOWN;
    }

    public static function createVocabWordByResponse($word, $response)
    {
        $vocabWord = new VocabWord();

        $vocabWord->type = MorpherParser::getTypeWordByResponse($response) ?? null;
        $vocabWord->nominative = $word;
        $vocabWord->dative = $response['Д'] ?? null;
        $vocabWord->genitive = $response['Р'] ?? null;
        $vocabWord->instrumental = $response['Т'] ?? null;
        $vocabWord->prepositional = $response['П'] ?? null;

        if (!empty($response['множественное']) && is_array($response['множественное'])) {
            $response = $response['множественное'];

            $vocabWord->plural_nominative = $response['И'] ?? null;
            $vocabWord->plural_dative = $response['Д'] ?? null;
            $vocabWord->plural_genitive = $response['Р'] ?? null;
            $vocabWord->plural_instrumental = $response['Т'] ?? null;
            $vocabWord->plural_prepositional = $response['П'] ?? null;
        }

        $vocabWord->save();

        return $vocabWord;
    }
}
