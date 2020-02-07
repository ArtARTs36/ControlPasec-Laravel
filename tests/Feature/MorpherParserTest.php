<?php

namespace Tests\Feature;

use App\Models\Vocab\VocabWord;
use App\Parsers\MorpherParser\MorpherParser;
use Tests\TestCase;

class MorpherParserTest extends TestCase
{
    public function testGetDeclensions()
    {
        $word = 'Молоко';

        $response = MorpherParser::findDeclensions($word, false);

        foreach (['Р', 'Д', 'В', 'Т', 'П'] as $declension) {
            self::assertArrayHasKey($declension, $response);
        }
    }

    public function testGetTypeWordByResponseForFamily()
    {
        $data = ['ФИО' => [
            'Ф' => 'Украинский',
            'И' => '',
            'О' => '',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_FAMILY);
    }

    public function testGetTypeWordByResponseForName()
    {
        $data = ['ФИО' => [
            'Ф' => '',
            'И' => 'Артем',
            'О' => '',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_NAME);
    }

    public function testGetTypeWordByResponseForPatronymic()
    {
        $data = ['ФИО' => [
            'Ф' => '',
            'И' => '',
            'О' => 'Викторович',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_PATRONYMIC);
    }

    public function testGetTypeWordByResponseForUnknown()
    {
        $data = '';

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_UNKNOWN);
    }
}
