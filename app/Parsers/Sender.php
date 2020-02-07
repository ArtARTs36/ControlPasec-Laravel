<?php

namespace App\Parsers;

/**
 * Class Sender
 */
abstract class Sender
{
    /**
     * Подготовка URL к отправке запроса GET-Запроса
     *
     * @param $ch
     * @param $url
     * @param $params
     * @return string
     */
    protected static function prepareUrl($ch, $url, $params)
    {
        if ($params !== null && !empty($params)) {
            $url .= '?';
            foreach ($params as $key => $value) {
                $url .= $key . '=' . curl_escape($ch, $value) . '&';
            }
            $url = rtrim($url, '&');
        }

        return $url;
    }

    /**
     * @param $url
     * @param $params
     * @param $headers
     * @param null $options
     * @return false|resource
     */
    public static function curlInit($url, $params, $headers, $options = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, static::BASE_URL . self::prepareUrl($ch, $url, $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($options !== null && is_array($options)) {
            foreach ($options as $option => $value) {
                curl_setopt($ch, $option, $value);
            }
        }

        return $ch;
    }

    /**
     * @param $ch
     * @return bool|string
     */
    public static function curlExec($ch)
    {
        $result = curl_exec($ch);
        if ($result === false) {
            throw new \LogicException(curl_error($ch));
        }

        return $result;
    }

    /**
     * Получить результат из запроса
     *
     * @param $ch
     * @param null $request
     * @param string $format
     * @return bool|mixed|string|null
     */
    public static function getResultOfRequest($ch, $request = null, string $format = 'json')
    {
        if ($request === null) {
            $request = self::curlExec($ch);

            curl_close($ch);
        }

        return ($format == 'json' ? json_decode($request, true) : $request);
    }

    /**
     * Выполнить отправку
     *
     * @param string $url
     * @param array $params
     * @param array $options
     * @return bool|mixed|string|null
     */
    public static function executeSending(string $url, array $params, array $options)
    {
        return self::getResultOfRequest(
            self::curlInit($url, $params, $options)
        );
    }
}
