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
    private function getRandomDocumentByType($type): Document
    {
        return Document::query()->where('type_id', $type)
            ->inRandomOrder()
            ->first();
    }

    /**
     * @param $type
     * @return mixed
     */
    private function buildRandomDocumentByType($type)
    {
        $document = $this->getRandomDocumentByType($type);

        return DocumentBuilder::build($document);
    }
}
