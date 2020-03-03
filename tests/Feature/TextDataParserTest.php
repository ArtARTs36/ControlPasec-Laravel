<?php

namespace Tests\Feature;

use App\Models\TextDataParser\TextDataParserComponent;
use App\Services\TextDataParser\TextDataParserFactory;
use App\Services\TextDataParser\TextDataParserInterface;
use Tests\BaseTestCase;

class TextDataParserTest extends BaseTestCase
{
    public function testFactoryGet()
    {
        $parser = TextDataParserFactory::get(
            $this->getFaker()->text,
            $this->getRandomModel(TextDataParserComponent::class)
        );

        self::assertInstanceOf(TextDataParserInterface::class, $parser);
    }
}
