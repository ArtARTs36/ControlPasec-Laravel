<?php

namespace App\Parsers\MorpherParser;

use App\Parsers\Sender;

class MorpherSender extends Sender
{
    const BASE_URL = 'https://ws3.morpher.ru/';

    const URL_METHOD_DECLENSION = 'russian/declension';

    const ERROR_LIMIT = 1;
    const ERROR_LIMIT_TEXT = 'Превышен лимит на сервисе Morpher';

    /**
     * @param $url
     * @param null $params
     * @return mixed
     */
    public static function getRequest($url, $params = NULL)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::BASE_URL . self::prepareUrl($ch, $url, $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,
            CURLOPT_HTTPHEADER,
            [
                'Accept: application/json',
                //'Authorization: Basic YThkYWI1ZmUtN2E0Ny00YzE3LTg0ZWEtNDZmYWNiN2QxOWZl'
            ]
        );

        $result = curl_exec($ch);
        if ($result === false) {
            throw new \LogicException(curl_error($ch));
        }

        $json = json_decode($result, true);
        curl_close($ch);

        if (isset($json['code']) && $json['code'] == self::ERROR_LIMIT) {
            throw new \LogicException(self::ERROR_LIMIT_TEXT);
        }

        return $json;
    }
}
