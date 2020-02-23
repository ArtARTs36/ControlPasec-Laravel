<?php

namespace App\Services\Document\DocumentJoiner;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;

abstract class AbstractDocumentJoiner
{
    /**
     * @return string|false
     */
    abstract public function join();

    const OUTPUT_FILE_EXTENSION = '';

    /** @var array */
    protected $filesPaths = null;

    /** @var string */
    protected $savePath = null;

    /**
     * @param array|Document[] $documents
     * @param string|null $savePath
     */
    public function __construct($documents, string $savePath = null)
    {
        $this->prepareFilesPaths($documents);
        $this->prepareSavePath();
    }

    protected function prepareSavePath(): void
    {
        $this->savePath = $savePath ?? $this->filesPaths[0] . '.merged.'. static::OUTPUT_FILE_EXTENSION;
    }

    protected function prepareFilesPaths($documents): void
    {
        foreach ($documents as $document) {
            if ($document instanceof Document) {
                $this->filesPaths[] = DocumentService::getDownloadLink($document, true);
            } else {
                $this->filesPaths[] = $document;
            }
        }
    }
}
