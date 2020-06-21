<?php

namespace App\Services\Document;

use App\Jobs\DocumentBuildJob;
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
        $document->title = static::parseFileName($document);
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

        $pathTmpFile = views_path() . $tmpFileName . '.blade.php';

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
     * @param int|array|Document $id
     * @return object|null|Document
     */
    public static function getDocument($id)
    {
        if ($id instanceof Document) {
            return $id;
        }

        if (is_array($id)) {
            $id = $id['id'];
        }

        $document = Document::query()->find($id);
        if (null === $document) {
            throw new \LogicException('Документ не найден');
        }

        return $document;
    }

    /**
     * @param Document $document
     * @param bool $force
     * @return string
     * @throws \ReflectionException
     */
    public static function buildWithSpeedAnalyse(Document $document, bool $force = false)
    {
        if ($force === false && $document->fileExists()) {
            return $document->getFullPath();
        }

        if (DocumentBuildSpeedAnalyser::analyse($document) === DocumentBuildSpeedAnalyser::ANSWER_BUILD_NOW) {
            DocumentBuilder::build($document);
        } else {
            $document->setStatusInQueue();

            DocumentBuildJob::dispatch($document)
                ->onConnection('redis');
        }

        return $document->getFullPath();
    }

    public static function buildIfNotExists(Document $document): string
    {
        if (!$document->fileExists()) {
            DocumentBuilder::build($document);
        }

        return $document->getFullPath();
    }
}
