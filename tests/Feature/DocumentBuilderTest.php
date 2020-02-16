<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Services\Document\DocumentBuilder;
use Tests\BaseTestCase;

class DocumentBuilderTest extends BaseTestCase
{
    public function testBuild()
    {
        $randomDocument = Document::where('status', Document::STATUS_NEW)
            ->inRandomOrder()
            ->get()
            ->first();

        $build = DocumentBuilder::build($randomDocument, true);

        self::assertNotFalse($build);
    }

    public function testBuildMany()
    {
        $randomDocument = Document::where('status', Document::STATUS_NEW)
            ->inRandomOrder()
            ->get()
            ->first();

        $build = DocumentBuilder::buildMany([$randomDocument, $randomDocument], true);

        self::assertTrue($build);
    }
}
