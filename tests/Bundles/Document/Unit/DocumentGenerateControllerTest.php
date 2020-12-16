<?php

namespace Tests\Bundles\Document\Unit;

use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Supply\Models\OneTForm;
use App\Bundles\Supply\Models\ProductTransportWaybill;
use App\Bundles\Supply\Models\QualityCertificate;
use App\Bundles\Supply\Models\ScoreForPayment;
use App\Bundles\Supply\Models\Supply;
use Tests\BaseTestCase;
use Tests\Bundles\Contragent\Generators\ContragentGenerator;

class DocumentGenerateControllerTest extends BaseTestCase
{
    /**
     * @covers \App\Bundles\Document\Http\Controllers\DocumentGenerateController::generateManyTypes
     */
    public function testGenerateManyTypes(): void
    {
        $supplier = ContragentGenerator::gen();

        $supply = factory(Supply::class)->create([
            Supply::FIELD_SUPPLIER_ID => $supplier->id,
        ]);

        factory(ScoreForPayment::class)->create([
            ScoreForPayment::FIELD_SUPPLY_ID => $supply->id,
        ]);

        factory(QualityCertificate::class)->create([
            QualityCertificate::FIELD_SUPPLY_ID => $supply->id,
        ]);

        factory(OneTForm::class)->create([
            OneTForm::FIELD_SUPPLY_ID => $supply->id,
        ]);

        factory(ProductTransportWaybill::class)->create([
            ProductTransportWaybill::FIELD_SUPPLY_ID => $supply->id,
        ]);

        //

        $response = $this->postJson('/api/generate-documents/'. $supply->id, [
            'types' => [
                DocumentType::SCORE_FOR_PAYMENT_ID,
                DocumentType::ONE_T_FORM_ID,
                DocumentType::TORG_12_ID,
                DocumentType::QUALITY_CERTIFICATE_ID,
            ]
        ]);

        $decode = $response->decodeResponseJson();

        dump($decode);

        $response->assertOk();

        self::assertIsArray($decode);
        self::assertArrayHasKey('data', $decode);
        self::assertArrayHasKey('title', $decode['data']);
        self::assertNotEmpty($decode['data']['title']);
        self::assertArrayHasKey('timestamp', $decode['data']);
        self::assertNotEmpty($decode['data']['timestamp']);
    }
}
