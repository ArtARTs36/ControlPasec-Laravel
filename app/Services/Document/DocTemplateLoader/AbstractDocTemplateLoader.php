<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Exceptions\DocumentSaveFailed;

abstract class AbstractDocTemplateLoader
{
    const NAME = '';

    /**
     * @param Document $document
     * @return string
     */
    abstract protected function make(Document $document): string;

    /**
     * @param array $documents
     * @return string
     */
    abstract protected function makeMany($documents): string;

    /**
     * @param Document $document
     * @return string
     */
    public function load(Document $document): string
    {
        return $this->make($document);
    }

    /**
     * @param array $documents
     * @return string
     */
    public function loadMany($documents): string
    {
        return $this->makeMany($documents);
    }

    /**
     * Получить путь для сохранения документа
     *
     * @param Document $document
     * @return string
     * @throws \Exception
     */
    public function getSavePath(Document $document)
    {
        $dir = implode(DIRECTORY_SEPARATOR, [
            base_path(env('DOCUMENT_SAVE_DIR')),
            $document->getFolder(),
            $document->uuid
        ]);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir . DIRECTORY_SEPARATOR . $document->getFileName();
    }

    /**
     * Сохранить документ
     *
     * @param Document $document
     * @param string $output
     * @param string|null $path
     * @return string
     * @throws \Exception
     */
    protected function saveDocument(Document $document, string $output, string $path = null)
    {
        if ($path === null) {
            $path = $this->getSavePath($document);
        }

        if (file_put_contents($path, $output) === false) {
            throw new DocumentSaveFailed($document);
        }

        return $path;
    }

    /**
     * @param Document $document
     * @return array
     */
    protected function includeData(Document $document): array
    {
        $path = __DIR__ . '/../../../../resources/views/' .
            $document->getTemplate() . '_data.php';

        return include $path;
    }
}
