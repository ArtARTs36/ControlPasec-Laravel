<?php

namespace Tests\Based\Unit;

use App\Bundles\Contragent\Models\Contragent;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use App\Models\TextDataParser\TextDataParserComponent;
use App\Services\TextDataParser\LightTextDataParser;
use Tests\BaseTestCase;

class LightTextDataParserTest extends BaseTestCase
{
    public function testParseFirstComponent(): void
    {
        $parser = new LightTextDataParser();
        $data = $parser->parse(
            $this->createInputString(),
            TextDataParserComponent::find(TextDataParserComponent::FIRST_COMPONENT_ID)
        );

        self::assertIsArray($data);
        self::assertIsArray($data[0]);
        self::assertInstanceOf(Contragent::class, $data[0]['customer']);
        self::assertInstanceOf(Supply::class, $data[0]['supply']);
        self::assertInstanceOf(Contragent::class, $data[0]['supplier']);
        self::assertInstanceOf(SupplyProduct::class, $data[0]['supplyProduct']);
    }

    private function createInputString(): string
    {
        return implode('	', [
            rand(1, 99),
            $this->getRandomModel(Contragent::class)->title,
            '',
            rand(1, 99),
            rand(1, 99),
            rand(4000, 12000),
        ]);
    }
}
