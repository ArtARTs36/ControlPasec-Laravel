<?php

namespace App\Services\Document;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * Class DocumentConverter
 *
 * @package App\Services\Document
 */
class DocumentConverter
{
    use XlsxDocumentConverterTrait;

    /**
     * @param string $path
     * @param string $extension
     * @return string
     */
    public static function createNewFilePath(string $path, string $extension): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.' . $extension;
    }

    /**
     * Получить директорию
     *
     * @param string $path
     * @return string
     */
    private static function getDir(string $path): string
    {
        return pathinfo($path)['dirname'];
    }

    /**
     * Проверить файл на существование
     *
     * @param string $filePath
     * @return bool
     */
    private static function checkFileExists(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        return true;
    }

    /**
     * @param $command
     * @param $file
     * @param $ext
     * @return string|null
     * @throws DocumentConvertException
     */
    private static function shell($command, $file, $ext)
    {
        $shellResult = shell_exec($command);
        if ($shellResult === null) {
            throw new DocumentConvertException($file, $ext);
        }

        return $shellResult;
    }
}
