<?php

namespace Tests\Feature;

use App\Models\Vocab\VocabWord;
use App\Parsers\MorpherParser\MorpherParser;
use Tests\TestCase;

class MorpherParserTest extends TestCase
{
    public function testGetDeclensions(): void
    {
        $word = 'Молоко';

        $response = MorpherParser::findDeclensions($word, false);

        foreach (['Р', 'Д', 'В', 'Т', 'П'] as $declension) {
            self::assertArrayHasKey($declension, $response);
        }
    }

    public function testGetTypeWordByResponseForFamily(): void
    {
        $data = ['ФИО' => [
            'Ф' => 'Украинский',
            'И' => '',
            'О' => '',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_FAMILY);
    }

    public function testGetTypeWordByResponseForName(): void
    {
        $data = ['ФИО' => [
            'Ф' => '',
            'И' => 'Артем',
            'О' => '',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_NAME);
    }

    public function testGetTypeWordByResponseForPatronymic(): void
    {
        $data = ['ФИО' => [
            'Ф' => '',
            'И' => '',
            'О' => 'Викторович',
        ]];

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_PATRONYMIC);
    }

    public function testGetTypeWordByResponseForUnknown(): void
    {
        $data = '';

        $answer = MorpherParser::getTypeWordByResponse($data);

        self::assertTrue($answer == VocabWord::TYPE_UNKNOWN);
    }
}
