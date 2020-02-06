<?php

namespace App\Services;

use App\Models\Contragent;
use App\Parsers\DaDataParser\DaDataParser;

class ContragentService
{
    public static function getContragent($title, $inn)
    {
        return Contragent::where('title', $title) ?? DaDataParser::findContragentByInnOrOGRN($inn);
    }
}
