<?php

namespace Tests\Feature;

use App\Models\Document\DocumentType;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentConverter;
use Tests\BaseTestCase;
use Tests\Traits\RandomDocumentTrait;

class DocumentConverterTest extends BaseTestCase
{
    use RandomDocumentTrait;

    public function testXlsxToPdfByFilePath()
    {
        $document = $this->getRandomDocumentByType(DocumentType::TORG_12_ID);
        $build = DocumentBuilder::build($document);
        self::assertFileExists($build);

        $newFilePath = DocumentConverter::xlsxToPdf($build);
        self::assertFileExists($newFilePath);
    }

    public function testXlsxToPdfByDocument()
    {
        $document = $this->getRandomDocumentByType(DocumentType::TORG_12_ID);
        $build = DocumentBuilder::build($document);
        self::assertFileExists($build);

        $newFilePath = DocumentConverter::xlsxToPdf($document);
        self::assertFileExists($newFilePath);
    }
}
