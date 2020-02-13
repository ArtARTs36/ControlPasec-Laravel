<?php

namespace DocumentBundle\Helper;

class TextMinificator
{
    /**
     * Минифицировать текст
     *
     * @param $source
     * @param bool $isLoadCache
     * @return mixed
     */
    public static function minify(&$source, $isLoadCache = true)
    {
        self::parseText($source);

        return $source;
    }

    /**
     * Минифицировать текст, получив путь до файла, который его содержит
     *
     * @param $sourcePath
     * @param bool $isLoadCache
     * @return mixed
     */
    public static function minifyByPath($sourcePath, $isLoadCache = true)
    {
        if (!file_exists($sourcePath)) {
            throw new \LogicException('Файл не существует!');
        }

        $source = file_get_contents($sourcePath);

        return self::minify($source, $isLoadCache);
    }

    /**
     * Обработать текст
     *
     * @param $source
     */
    public static function parseText(&$source)
    {
        $source = str_replace("\r\n", "", $source);
        $source = str_replace("\n", "", $source);
        $source = preg_replace('/ {2,}/', '', $source);
    }
}
