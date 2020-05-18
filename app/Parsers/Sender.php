<?php

namespace App\Parsers;

/**
 * Class Sender
 */
abstract class Sender
{
    const BASE_URL = '';

    /**
     * Подготовка URL к отправке запроса GET-Запроса
     *
     * @param resource $ch
     * @param string $url
     * @param array $params
     * @return string
     */
    protected static function prepareUrl($ch, string $url, array $params): string
    {
        if (!empty($params)) {
            $url .= '?';
            foreach ($params as $key => $value) {
                $url .= $key . '=' . curl_escape($ch, $value) . '&';
            }
            $url = rtrim($url, '&');
        }

        return $url;
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param array $options
     * @return false|resource
     */
    public static function curlInit(string $url, array $params, array $headers, array $options = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, static::BASE_URL . self::prepareUrl($ch, $url, $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (is_array($options)) {
            foreach ($options as $option => $value) {
                curl_setopt($ch, $option, $value);
            }
        }

        return $ch;
    }

    /**
     * @param resource $ch
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
     * @param resource $ch
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
