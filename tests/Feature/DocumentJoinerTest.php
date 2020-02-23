<?php

namespace Tests\Feature;

use App\Models\Document\DocumentType;
use App\Services\Document\DocumentJoiner;
use Tests\BaseTestCase;
use Tests\Traits\RandomDocumentTrait;

class DocumentJoinerTest extends BaseTestCase
{
    use RandomDocumentTrait;

    public function testPdf()
    {
        $documents = [
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
        ];

        $pdf = DocumentJoiner::pdf($documents);

        self::assertFileExists($pdf);
    }
}
