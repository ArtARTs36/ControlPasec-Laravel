<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Service\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class DocumentCreatorTest extends BaseTestCase
{
    public function testCreateDocument()
    {
        $document = DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->save();

        self::assertTrue($document->id > 0);
    }
}
