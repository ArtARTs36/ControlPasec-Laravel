<?php

namespace App\Helper;

/**
 * Class FileHelper
 */
class FileHelper
{
    /**
     * Сменить расширение у файла
     * @param string $path
     * @param string $newExt
     * @return string
     */
    public static function changeExtensionInPath(string $path, string $newExt): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.'. $newExt;
    }

    /**
     * Создать файл, если он не существует
     * @param string $path
     * @param string $content
     */
    public static function createFileIfNotExists(string $path, string $content): void
    {
        if (!file_exists($path)) {
            file_put_contents($path, $content);
        }
    }
}
