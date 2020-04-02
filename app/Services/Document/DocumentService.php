<?php

namespace App\Service\Document;

use App\Models\Document\Document;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentBuildSpeedAnalyser;
use App\User;

class DocumentService
{
    /**
     * Обновить название файла
     *
     * @param Document $document
     * @return Document
     * @throws \Throwable
     */
    public static function refreshFileName(Document $document)
    {
        $document->title = self::parseFileName($document);
        $document->save();
        return $document;
    }

    /**
     * Сгенерировать название для файла
     *
     * @param Document $document
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public static function parseFileName(Document $document)
    {
        $tmpFileName = env('DOCUMENT_TMP_NAMES_DIR') . DIRECTORY_SEPARATOR . time();
        $pathTmpFile = __DIR__ . '/../../../resources/views/'. $tmpFileName . '.blade.php';
        file_put_contents($pathTmpFile, $document->type->title);

        $fileName = view($tmpFileName, ['doc' => $document])->render() . '.' . $document->getExtensionName();

        unlink($pathTmpFile);

        return $fileName;
    }

    public static function getDownloadLink($document, $full = false)
    {
        $document = self::getDocument($document);

        $path = implode(DIRECTORY_SEPARATOR, [
            '',
            env('DOCUMENT_DOWNLOAD_DIR'),
            $document->getFolder(),
            $document->uuid,
            $document->getFileName()
        ]);

        return ($full ? public_path($path) : $path);
    }

    /**
     * @param int|Document $id
     * @return object|null|Document
     */
    public static function getDocument($id)
    {
        if ($id instanceof Document) {
            return $id;
        }

        $document = Document::find($id);
        if (null === $document) {
            throw new \LogicException('Документ не найден');
        }

        return $document;
    }

    public static function buildWithSpeedAnalyse(Document $document, bool $force = false)
    {
        if ($force === false && $document->fileExists()) {
            return $document->getFullPath();
        }

        $analyse = DocumentBuildSpeedAnalyser::analyse($document);
        if ($analyse === DocumentBuildSpeedAnalyser::ANSWER_BUILD_NOW) {
            DocumentBuilder::build($document, true);
        } else {
            // todo push Document in Queue
        }

        return $document->getFullPath();
    }

    public static function buildIfNotExists(Document $document): string
    {
        if (!$document->fileExists()) {
            DocumentBuilder::build($document, true);
        }

        return $document->getFullPath();
    }
}
