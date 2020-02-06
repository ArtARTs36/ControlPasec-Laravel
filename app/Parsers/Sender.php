<?php

namespace App\Parsers;

abstract class Sender
{
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
}
