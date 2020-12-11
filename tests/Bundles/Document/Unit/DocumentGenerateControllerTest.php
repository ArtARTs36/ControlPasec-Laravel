<?php

namespace Tests\Bundles\Document\Unit;

use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Supply\Models\Supply;
use Tests\BaseTestCase;

class DocumentGenerateControllerTest extends BaseTestCase
{
    /**
     * @covers \App\Bundles\Document\Http\Controllers\DocumentGenerateController::generateManyTypes
     */
    public function testGenerateManyTypes(): void
    {
        // @todo нужно править
        $supply = $this->getRandomModel(Supply::class);

        $response = $this->postJson('/api/generate-documents/'. $supply->id, [
            'types' => [
                DocumentType::SCORE_FOR_PAYMENT_ID,
                DocumentType::ONE_T_FORM_ID,
                DocumentType::TORG_12_ID,
                DocumentType::QUALITY_CERTIFICATE_ID,
            ]
        ]);

        $decode = $response->decodeResponseJson();

        $response->assertOk();

        self::assertIsArray($decode);
        self::assertArrayHasKey('data', $decode);
        self::assertArrayHasKey('title', $decode['data']);
        self::assertNotEmpty($decode['data']['title']);
        self::assertArrayHasKey('timestamp', $decode['data']);
        self::assertNotEmpty($decode['data']['timestamp']);
    }
}
