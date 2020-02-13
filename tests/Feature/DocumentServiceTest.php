<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Service\Document\DocumentService;
use Tests\BaseTestCase;

class DocumentServiceTest extends BaseTestCase
{
    public function testCreateDocument()
    {
        $document = DocumentService::createDocument(1,false);

        self::assertTrue($document->id > 0);
    }
}
