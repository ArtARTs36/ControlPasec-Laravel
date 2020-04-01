<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\Supply;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentCreator;
use Tests\BaseTestCase;
use Tests\Traits\RandomDocumentTrait;

/**
 * @group BaseTest
 */
class DocumentBuilderTest extends BaseTestCase
{
    use RandomDocumentTrait;

    public function testBuild(): void
    {
        $randomDocument = Document::where('status', Document::STATUS_NEW)
            ->inRandomOrder()
            ->first();

        $build = DocumentBuilder::build($randomDocument, true);

        self::assertNotFalse($build);
    }

    public function testBuildMany(): void
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

    public function testBuildScoreForPayment(): void
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
            true
        );

        self::assertFileExists($build);
    }

    /**
     * @throws \Throwable
     */
    public function testBuildQualityCertificate(): void
    {
        $supply = $this->getRandomModel(Supply::class);

        $certificate = new QualityCertificate();
        $certificate->supply_id = $supply->id;
        $certificate->save();

        $document = DocumentCreator::getInstance(DocumentType::QUALITY_CERTIFICATE_ID)
            ->addQualityCertificates($certificate)
            ->save();

        $build = DocumentBuilder::build(
            $document,
            true
        );

        self::assertFileExists($build);
    }

    public function testBuildTorg12(): void
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::TORG_12_ID),
            true
        );

        self::assertFileExists($build);
    }

    public function testBuildOneTForm(): void
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::ONE_T_FORM_ID),
            true
        );

        self::assertFileExists($build);
    }
}
