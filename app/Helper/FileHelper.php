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

    public static function findFilesWithCallable($path, &$files, callable $checkFileFunction = null)
    {
        if (is_dir($path)) {
            $cleanPath = self::cleanBackPathsByFiles(scandir($path));
            foreach ($cleanPath as $file) {
                $finalPath = $path . '/' . $file;
                $result = self::findFilesWithCallable($finalPath, $files, $checkFileFunction);
                if (!is_null($result)) {
                    $files[] = $result;
                }
            }
        } elseif (is_file($path) && is_callable($checkFileFunction) && $checkFileFunction($path)) {
            return $path;
        }
    }

    public static function findPhpClass(string $path): array
    {
        $classPaths = [];
        FileHelper::findFilesWithCallable($path, $classPaths, function ($file) {
            return FileHelper::fileIsPhpClasses($file);
        });

        return $classPaths;
    }

    /**
     * Является ли файл классом PHP
     *
     * @param $path
     * @return bool
     */
    public static function fileIsPhpClasses($path)
    {
        $extension = substr($path, -4, 4);
        if ($extension != '.php') {
            return false;
        }

        $fileParse = explode("/", $path);

        $fileWithoutExtension = substr(
            end($fileParse),
            0,
            -4
        );

        // Is Camel Case
        return ($fileWithoutExtension == ucwords($fileWithoutExtension));
    }

    /**
     * Поиск папок
     *
     * @param $path
     * @return array
     */
    public static function findFolders($path)
    {
        $dirs = [];

        $files = self::cleanBackPathsByFiles(scandir($path));
        foreach ($files as $file) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $file;
            if (is_dir($fullPath)) {
                $dirs[] = realpath($fullPath);
            }
        }

        return $dirs;
    }

    public static function cleanBackPathsByFiles($files)
    {
        return array_diff($files, ['.', '..']);
    }
}
