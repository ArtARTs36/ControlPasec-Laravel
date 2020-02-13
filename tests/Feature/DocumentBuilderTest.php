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
            ->first()
            ->get()[0];

        $build = DocumentBuilder::build($randomDocument, true);

        self::assertTrue($build);
    }
}
