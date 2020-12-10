<?php

namespace App\Based\Support\Archiver;

use App\Based\Support\FileHelper;
use App\Bundles\Document\Support\ArchivePath;
use ArtARTs36\ShellCommand\ShellCommand;

class Zipper extends AbstractArchiver
{
    /**
     * Сжать файлы, сохраняя относительные пути
     */
    public function compress(array $files, string $archiveName): Archive
    {
        $tmpDir = FileHelper::getTmpFolder($timestamp);

        $files = array_map(function ($file) use ($tmpDir) {
            $fileName = FileHelper::getFileName($file);

            copy($file, $tmpDir . DIRECTORY_SEPARATOR . $fileName);

            return $fileName;
        }, $files);

        $archivePath = $this->prepareArchivePath($archiveName, $timestamp);

        $command = $this->createCommand($tmpDir, $archivePath, $files);

        $command->execute();

        FileHelper::removeDir($tmpDir);

        return new Archive($files, $archiveName, $archivePath, $timestamp);
    }

    /**
     * Сжать файлы, сохраняя абсолютные пути
     * @param array $files
     * @param string $archiveName
     * @return Archive
     */
    public function compressWithDir(array $files, string $archiveName): Archive
    {
        $command = (new ShellCommand('zip', false))
            ->addCutOption('r')
            ->addParameter($archiveName)
            ->addParameters($files);

        $command->execute();

        return new Archive($files, $archiveName, $archiveName);
    }

    /**
     * Сжать файлы директории
     * @param string $dir
     * @param string $archiveName
     * @return Archive
     */
    public function compressDirectory(string $dir, string $archiveName): Archive
    {
        $archivePath = $this->prepareArchivePath($archiveName);

        $files = FileHelper::findFilesWithoutDir($dir);

        $command = $this->createCommand($dir, $archivePath, $files);

        $command->execute();

        return new Archive($files, $archiveName, $archivePath);
    }

    private function createCommand(string $dir, string $archivePath, array $files): ShellCommand
    {
        return (new ShellCommand('cd', false))
            ->addParameter($dir)
            ->addAmpersands()
            ->addParameter('zip')
            ->addCutOption('r')
            ->addParameter($archivePath)
            ->addParameters($files);
    }

    private function prepareArchivePath(string $archiveName, int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();

        $archiveName = FileHelper::changeExtensionIfNotOur($archiveName, 'zip');

        return ArchivePath::getStoragePath($timestamp, $archiveName);
    }
}
