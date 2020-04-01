<?php

namespace App\Support\Archiver;

use App\Helper\FileHelper;
use App\Services\Shell\ShellCommand;

class Zipper extends AbstractArchiver
{
    /**
     * Сжать файлы, сохраняя относительные пути
     * @param array $files
     * @param string $archiveName
     * @return Archive
     */
    public function compress(array $files, string $archiveName): Archive
    {
        $tmpDir = FileHelper::getTmpFolder();

        $files = array_map(function ($file) use ($tmpDir) {
            $fileName = FileHelper::getFileName($file);

            copy($file, $tmpDir . DIRECTORY_SEPARATOR . $fileName);

            return $fileName;
        }, $files);

        $archiveName = $this->prepareArchivePath($archiveName);

        $command = $this->createCommand($tmpDir, $archiveName, $files);

        $command->execute();

        FileHelper::removeDir($tmpDir);

        return new Archive($files, $archiveName);
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

        return new Archive($files, $archiveName);
    }

    /**
     * Сжать файлы директории
     * @param string $dir
     * @param string $archiveName
     * @return Archive
     */
    public function compressDirectory(string $dir, string $archiveName): Archive
    {
        $archiveName = $this->prepareArchivePath($archiveName);

        $files = FileHelper::findFilesWithoutDir($dir);

        $command = $this->createCommand($dir, $archiveName, $files);

        $command->execute();

        return new Archive($files, $archiveName);
    }

    private function createCommand(string $dir, string $archiveName, array $files): ShellCommand
    {
        return (new ShellCommand('cd', false))
            ->addParameter($dir)
            ->addAmpersands()
            ->addParameter('zip')
            ->addCutOption('r')
            ->addParameter($archiveName)
            ->addParameters($files);
    }

    private function prepareArchivePath(string $archiveName): string
    {
        $archiveName = FileHelper::changeExtensionIfNotOur($archiveName, 'zip');

        $archivesPath = storage_path('archives') . DIRECTORY_SEPARATOR;

        !file_exists($archivesPath) && mkdir($archivesPath, 0777, true);

        return $archivesPath . $archiveName;
    }
}
