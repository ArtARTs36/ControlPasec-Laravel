<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;
use App\Services\Shell\ShellCommand;
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
     * @param string|Document $filePath
     * @return bool
     */
    private static function checkFileExists(&$filePath)
    {
        if ($filePath instanceof Document) {
            $filePath = DocumentService::getDownloadLink($filePath, true);
        }

        if (!file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        return true;
    }

    /**
     * @param ShellCommand $command
     * @param string $file
     * @param string $ext
     * @return string
     * @throws DocumentConvertException
     */
    private static function checkShell(ShellCommand $command, string $file, string $ext)
    {
        $shellResult = $command->getShellResult();
        if ($shellResult === null) {
            throw new DocumentConvertException($file, $ext);
        }

        return $shellResult;
    }
}
