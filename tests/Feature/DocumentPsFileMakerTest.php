<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Services\Document\DocumentPsFileMaker;
use Tests\BaseTestCase;

class DocumentPsFileMakerTest extends BaseTestCase
{
    public function testJoin()
    {
        $oneDocument = Document::find(62);
        $twoDocument = Document::find(63);

        $joiner = DocumentPsFileMaker::getInstance()
            ->addDocument($oneDocument)
            ->addDocument($oneDocument);

        $file = $joiner->join();

        self::assertFileExists($file);
    }
}
