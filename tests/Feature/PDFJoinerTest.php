<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Service\Document\DocumentService;
use App\Services\Document\DocumentJoiner\PDFJoiner;
use Tests\BaseTestCase;

class PDFJoinerTest extends BaseTestCase
{
    public function testJoin()
    {
        $docs = Document::where('type_id', DocumentType::SCORE_FOR_PAYMENT_ID)
            ->take(rand(2, 10))
            ->get();

        foreach ($docs as $doc) {
            DocumentService::buildIfNotExists($doc);
        }

        $file = (new PDFJoiner($docs))->join();

        self::assertFileExists($file);
    }
}
