<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class DocumentCreatorTest extends BaseTestCase
{
    public function testCreateDocument(): void
    {
        $document = DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->save();

        self::assertGreaterThan(1, $document->id);
    }
}
