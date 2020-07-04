<?php

namespace App\Parsers\DaDataParser;

use App\Parsers\Sender;

/**
 * Class DaDataSender
 *
 * Отправитель запросов для сайта dadata.ru
 */
class DaDataSender extends Sender
{
    const BASE_URL = 'https://suggestions.dadata.ru/suggestions/api/4_1/';
    const URL_METHOD_FIND_PARTY_BY_INN = 'rs/findById/party';
    const ACCESS_KEY = 'bd0f0bb6afa265cda47baacbdb7bdd4c077ffc64';

    public static function send($url, $params = null)
    {
        return self::executeSending($url, $params, [
            'Accept: application/json',
            'Authorization: Token '. self::ACCESS_KEY
        ]);
    }
}
