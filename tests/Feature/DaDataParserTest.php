<?php

namespace Tests\Feature;

use App\Models\Contragent;
use App\Parsers\DaDataParser\DaDataParser;
use Tests\TestCase;

class DaDataParserTest extends TestCase
{
    public function testFindContragentByInn(): void
    {
        $response = DaDataParser::findContragentByInnOrOGRN('3612006131', false);

        self::assertArrayHasKey('suggestions', $response);
    }

    public function testParseManager(): void
    {
        $contragent = new Contragent();
        $contragent->id = 1;

        $data = [
            'management' => [
                'name' => 'Украинский Артем Викторович',
                'post' => 'Директор'
            ],
        ];

        $manager = DaDataParser::parseManager($data, $contragent, false);

        self::assertTrue(
            $manager->family == 'Украинский' && $manager->name == 'Артем' &&
            $manager->patronymic == 'Викторович' && $manager->contragent_id == $contragent->id
        );
    }
}
