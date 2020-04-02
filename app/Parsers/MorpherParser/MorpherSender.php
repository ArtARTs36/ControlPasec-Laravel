<?php

namespace App\Parsers\MorpherParser;

use App\Parsers\Sender;

/**
 * Class MorpherSender
 *
 * Отправитель запросов для сайта morpher.ru
 */
class MorpherSender extends Sender
{
    const BASE_URL = 'https://ws3.morpher.ru/';

    const URL_METHOD_DECLENSION = 'russian/declension';

    const ERROR_LIMIT = 1;
    const ERROR_LIMIT_TEXT = 'Превышен лимит на сервисе Morpher';

    /**
     * @param string $url
     * @param array|null $params
     * @return mixed
     */
    public static function getRequest(string $url, array $params = null)
    {
        $result = self::executeSending($url, $params, ['Accept: application/json']);
        if (isset($result['code']) && $result['code'] == self::ERROR_LIMIT) {
            throw new \LogicException(self::ERROR_LIMIT_TEXT);
        }

        return $result;
    }
}
