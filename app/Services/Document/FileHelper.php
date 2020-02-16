<?php

namespace App\Services\Document;

/**
 * Class FileHelper
 */
class FileHelper
{
    /**
     * Сменить расширение у файла
     *
     * @param $path
     * @param $newExt
     * @return string
     */
    public static function changeExtension($path, $newExt)
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.'. $newExt;
    }
}
