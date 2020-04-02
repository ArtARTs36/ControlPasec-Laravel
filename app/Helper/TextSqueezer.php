<?php

namespace App\Helper;

class TextSqueezer
{
    /**
     * Минифицировать текст
     *
     * @param string $source
     * @return string
     */
    public static function minify(string &$source): string
    {
        self::parseText($source);

        return $source;
    }

    /**
     * Минифицировать текст, получив путь до файла, который его содержит
     *
     * @param string $sourcePath
     * @return mixed
     */
    public static function minifyByPath(string $sourcePath): string
    {
        if (!file_exists($sourcePath)) {
            throw new \LogicException('Файл не существует!');
        }

        $source = file_get_contents($sourcePath);

        return self::minify($source);
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
