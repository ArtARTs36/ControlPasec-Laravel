<?php

namespace Tests\Bundles\Document\Unit;

use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use Tests\BaseTestCase;

class DocumentCreatorTest extends BaseTestCase
{
    public function testCreateDocument(): void
    {
        $document = DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->save();

        self::assertGreaterThan(1, $document->id);
    }
}
