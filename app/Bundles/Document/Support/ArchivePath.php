<?php

namespace App\Bundles\Document\Support;

final class ArchivePath
{
    public static function getStoragePath(int $timestamp, string $archiveName): string
    {
        $archivesPath = storage_path('archives') . DIRECTORY_SEPARATOR . $timestamp;

        !file_exists($archivesPath) && mkdir($archivesPath, 0777, true);

        return storage_path(self::getRelativePath($timestamp, $archiveName));
    }

    public static function getRelativePath(int $timestamp, string $archiveName): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            'archives',
            $timestamp,
            $archiveName
        ]);
    }
}
