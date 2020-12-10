<?php

namespace Tests\Bundles\Document\Unit;

use App\Models\Document\DocumentType;
use App\Models\Supply\QualityCertificate;
use App\Models\Supply\Supply;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentCreator;
use Tests\BaseTestCase;
use Tests\Traits\RandomDocumentTrait;

class DocumentBuilderTest extends BaseTestCase
{
    use RandomDocumentTrait;

    public function testBuildMany(): void
    {
        $documents = [
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID),
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID)
        ];

        $build = DocumentBuilder::buildMany($documents);

        self::assertFileExists($build);
    }

    public function testBuildScoreForPayment(): void
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::SCORE_FOR_PAYMENT_ID)
        );

        self::assertFileExists($build);
    }

    /**
     * @throws \Throwable
     */
    public function testBuildQualityCertificate(): void
    {
        $supply = factory(Supply::class)->create();

        $certificate = new QualityCertificate();
        $certificate->supply_id = $supply->id;
        $certificate->save();

        $document = DocumentCreator::getInstance(DocumentType::QUALITY_CERTIFICATE_ID)
            ->addQualityCertificates($certificate)
            ->save();

        $build = DocumentBuilder::build($document);

        self::assertFileExists($build);
    }

    public function testBuildTorg12(): void
    {
        $build = DocumentBuilder::build($this->getRandomDocumentByType(DocumentType::TORG_12_ID));

        self::assertFileExists($build);
    }

    public function testBuildOneTForm(): void
    {
        $build = DocumentBuilder::build(
            $this->getRandomDocumentByType(DocumentType::ONE_T_FORM_ID)
        );

        self::assertFileExists($build);
    }
}
