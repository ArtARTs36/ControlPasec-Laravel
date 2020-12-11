<?php

namespace Tests\Bundles\Document\Unit;

use App\Bundles\Document\Support\PDFJoiner;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Services\Document\DocumentService;
use Tests\BaseTestCase;

final class PDFJoinerTest extends BaseTestCase
{
    /**
     * @covers \App\Bundles\Document\Support\PDFJoiner::join
     */
    public function testJoin(): void
    {
        // @todo переделать
        $docs = Document::query()
            ->where('type_id', DocumentType::SCORE_FOR_PAYMENT_ID)
            ->take(rand(2, 10))
            ->get();

        foreach ($docs as $doc) {
            DocumentService::buildIfNotExists($doc);
        }

        $file = app(PDFJoiner::class)->join($docs->all());

        self::assertFileExists($file);
    }
}
