<?php

use App\Models\TextDataParser\TextDataParserComponent;

class TextDataParserComponentSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(TextDataParserComponent::class, 'data_text_data_parser_components');
    }
}
