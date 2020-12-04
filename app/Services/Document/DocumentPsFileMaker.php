<?php

namespace App\Services\Document;

use App\Based\Support\FileHelper;
use ArtARTs36\ShellCommand\ShellCommand;
use Illuminate\Support\Collection;

/**
 * Class DocumentPsFileMaker
 *
 * Инструмент для создания файла печати .ps
 */
class DocumentPsFileMaker
{
    /** @var string */
    private $baseFileName = null;

    private $libreOffice;

    public function __construct(string $libreOffice)
    {
        $this->libreOffice = $libreOffice;
    }

    /**
     * @return string
     */
    public function join(Collection $documents): string
    {
        $inputDir = $outDir = '';

        $this->createTmpFolders($inputDir, $outDir);
        $this->copyFilesToInputDir($documents, $inputDir);

        $command = (new ShellCommand($this->libreOffice, false))
            ->addOption('headless')
            ->addOption('print-to-file')
            ->addOption('outdir')
            ->addParameter($outDir)
            ->addParameter($inputDir . '*');

        $result = $command->getShellResult();
        if (null === $result) {
            $this->handleException();
        }

        $outputFile = FileHelper::changeExtensionInPath(
            $outDir . DIRECTORY_SEPARATOR . $this->baseFileName,
            'ps'
        );

        if (! file_exists($outputFile)) {
            $this->handleException();
        }

        return $outputFile;
    }

    /**
     * @param string $inputDir
     */
    private function copyFilesToInputDir(Collection $documents, string $inputDir)
    {
        foreach ($documents as $key => $document) {
            $path = DocumentService::getDownloadLink($document, true);
            $newFileName = 'file-'. $key . '-'. $document->getFileName();
            $newPath = $inputDir . $newFileName;

            if ($key == 0) {
                $this->baseFileName = $newFileName;
            }

            copy($path, $newPath);
        }
    }

    /**
     * @param string $inputDir
     * @param string $outputDir
     */
    private function createTmpFolders(string &$inputDir, string &$outputDir)
    {
        $root = storage_path('documents_ps');
        if (!file_exists($root)) {
            mkdir($root, 0775);
        }

        $docFolder = $root . DIRECTORY_SEPARATOR . time();
        if (!file_exists($docFolder)) {
            mkdir($docFolder, 0775);
        }

        $inputDir = $docFolder . DIRECTORY_SEPARATOR . 'input/';
        $outputDir = $docFolder . DIRECTORY_SEPARATOR . 'output/';

        mkdir($inputDir, 0775);
        mkdir($outputDir, 0775);
    }

    private function handleException(): void
    {
        throw new \LogicException("Не удалось объединить файлы");
    }
}
