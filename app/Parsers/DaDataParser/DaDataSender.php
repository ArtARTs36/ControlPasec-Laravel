<?php

namespace App\Parsers\DaDataParser;

use App\Parsers\Sender;

class DaDataSender extends Sender
{
    const BASE_URL = 'https://suggestions.dadata.ru/suggestions/api/4_1/';

    const URL_METHOD_FIND_PARTY_BY_INN = 'rs/findById/party';

    const ACCESS_KEY = 'bd0f0bb6afa265cda47baacbdb7bdd4c077ffc64';

    public static function send($url, $params = NULL)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . self::prepareUrl($ch, $url, $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,
            CURLOPT_HTTPHEADER,
            array("Accept: application/json",
                "Authorization: Token ". self::ACCESS_KEY)
        );

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \LogicException(curl_error($ch));
        }

        $json = json_decode($result, true);
        curl_close($ch);

        return $json;
    }
}
