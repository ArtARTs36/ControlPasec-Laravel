<?php

namespace App\Helper;

class FileHelper
{
    /**
     * Сменить расширение у файла
     */
    public static function changeExtensionInPath(string $path, string $newExt): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.'. $newExt;
    }

    /**
     * Создать файл, если он не существует
     */
    public static function createFileIfNotExists(string $path, string $content): void
    {
        if (! file_exists($path)) {
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

    public static function findFiles($path, &$files)
    {
        if (is_dir($path)) {
            foreach (self::cleanBackPathsByFiles(scandir($path)) as $file) {
                $finalPath = $path . '/' . $file;
                $result = self::findFiles($finalPath, $files);
                if (!is_null($result)) {
                    $files[] = $result;
                }
            }
        } elseif (is_file($path)) {
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
     */
    public static function fileIsPhpClasses(string $path): bool
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
     */
    public static function findFolders(string $path): array
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

    public static function findFilesWithoutDir(string $dir): ?array
    {
        return array_values(array_diff(scandir($dir), ['.', '..']));
    }

    public static function getPrevDir(string $origDir): string
    {
        return pathinfo($origDir, PATHINFO_DIRNAME);
    }

    public static function getTmpFolder(int &$timestamp = null): string
    {
        $timestamp = time();

        $path = storage_path((string) $timestamp);

        mkdir($path, 0777, true);

        return $path;
    }

    public static function getFileName(string $fullPath): string
    {
        $info = pathinfo($fullPath);

        return $info['filename'] . '.' . $info['extension'];
    }

    public static function removeDir(string $dir): bool
    {
        $files = [];
        self::findFiles($dir, $files);

        foreach ($files as $file) {
            unlink($file);
        }

        rmdir($dir);

        return true;
    }

    public static function changeExtensionIfNotOur(string $file, string $extension): string
    {
        $parse = explode('.', $file);
        if (end($parse) === $extension) {
            return $file;
        }

        return $file . '.' . $extension;
    }
}
