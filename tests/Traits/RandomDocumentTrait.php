<?php

namespace Tests\Traits;

use App\Models\Document\Document;
use App\Services\Document\DocumentBuilder;

trait RandomDocumentTrait
{
    /**
     * @param $type
     * @return Document
     */
    private function getRandomDocumentByType($type)
    {
        return Document::where('type_id', $type)
            ->inRandomOrder()
            ->get()
            ->first();
    }

    private function buildRandomDocumentByType($type)
    {
        $document = $this->getRandomDocumentByType($type);

        return DocumentBuilder::build($document);
    }
}
