<?php

namespace App\Services\TextDataParser;

use App\Models\TextDataParser\TextDataParserComponent;

abstract class AbstractTextDataParser implements TextDataParserInterface
{
    abstract protected function process(): array;

    protected $inputString;

    /** @var TextDataParserComponent */
    protected $component;

    public function parse(string $inputString, TextDataParserComponent $component)
    {
        $this->inputString = $inputString;
        $this->component = $component;

        return $this->process();
    }
}
