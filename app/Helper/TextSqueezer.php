<?php

namespace DocumentBundle\Helper;

class TextSqueezer
{
    /**
     * Минифицировать текст
     *
     * @param string $source
     * @param bool $isLoadCache
     * @return mixed
     */
    public static function minify(string &$source, bool $isLoadCache = true): string
    {
        self::parseText($source);

        return $source;
    }

    /**
     * Минифицировать текст, получив путь до файла, который его содержит
     *
     * @param string$sourcePath
     * @param bool $isLoadCache
     * @return mixed
     */
    public static function minifyByPath(string $sourcePath, bool $isLoadCache = true): string
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
     * @param string $source
     */
    public static function parseText(string &$source): void
    {
        $source = str_replace("\r\n", "", $source);
        $source = str_replace("\n", "", $source);
        $source = preg_replace('/ {2,}/', '', $source);
    }
}
