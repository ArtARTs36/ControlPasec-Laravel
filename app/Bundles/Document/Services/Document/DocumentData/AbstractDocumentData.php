<?php

namespace App\Services\Document\DocumentData;

use App\Models\Document\Document;

abstract class AbstractDocumentData implements DocumentDataInterface
{
    abstract public function get();

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
