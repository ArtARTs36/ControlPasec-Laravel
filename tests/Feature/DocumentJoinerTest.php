<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Services\Document\DocumentJoiner;
use Tests\BaseTestCase;

class DocumentJoinerTest extends BaseTestCase
{
    public function testJoin()
    {
        $oneDocument = Document::find(62);
        $twoDocument = Document::find(63);

        $joiner = DocumentJoiner::getInstance()
            ->addDocument($oneDocument)
            ->addDocument($twoDocument);

        $file = $joiner->join();

        self::assertFileExists($file);
    }
}
