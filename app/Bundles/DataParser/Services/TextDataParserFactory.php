<?php

namespace App\Services\TextDataParser;

use App\Models\TextDataParser\TextDataParserComponent;

class TextDataParserFactory
{
    const DEFAULT_PARSER_CLASS = LightTextDataParser::class;

    public static function get(string $data, TextDataParserComponent $component)
    {
        $class = !empty($component->class) && class_exists($component->class) ?
            $component->class : self::DEFAULT_PARSER_CLASS;

        return new $class($data, $component);
    }
}
