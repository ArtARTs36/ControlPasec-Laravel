<?php

namespace Tests\Bundles\Document\Unit;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentJoiner\PDFJoiner;
use Tests\BaseTestCase;

final class PDFJoinerTest extends BaseTestCase
{
    public function testJoin()
    {
        $docs = Document::query()
            ->where('type_id', DocumentType::SCORE_FOR_PAYMENT_ID)
            ->take(rand(2, 10))
            ->get();

        foreach ($docs as $doc) {
            DocumentService::buildIfNotExists($doc);
        }

        $file = (new PDFJoiner($docs))->join();

        self::assertFileExists($file);
    }
}
