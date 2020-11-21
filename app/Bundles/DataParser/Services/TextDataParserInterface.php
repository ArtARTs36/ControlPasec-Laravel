<?php

namespace App\Services\TextDataParser;

use App\Models\TextDataParser\TextDataParserComponent;

interface TextDataParserInterface
{
    public function parse(string $inputString, TextDataParserComponent $component);
}
