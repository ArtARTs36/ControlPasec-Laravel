<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Services\Document\DocumentBuilder;
use Tests\BaseTestCase;
use Tests\Traits\RandomDocumentTrait;

class DocumentBuilderTest extends BaseTestCase
{
    use RandomDocumentTrait;

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
        $documents = [
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID)
        ];

        $build = DocumentBuilder::buildMany(
            $documents,
            true
        );

        self::assertTrue($build);
    }

    public function testBuildScoreForPayment()
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
            true
        );

        self::assertFileExists($build);
    }

    public function testBuildQualityCertificate()
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::QUALITY_CERTIFICATE_ID),
            true
        );

        self::assertFileExists($build);
    }

    public function testBuildTorg12()
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::TORG_12_ID),
            true
        );

        self::assertFileExists($build);
    }
}
