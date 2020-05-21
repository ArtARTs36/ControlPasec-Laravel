<?php

namespace Tests\Feature;

use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use Tests\BaseTestCase;

class DocumentGenerateControllerTest extends BaseTestCase
{
    public function testGenerateManyTypes()
    {
        $supply = $this->getRandomModel(Supply::class);

        $response = $this->postJson('/api/generate-documents/'. $supply->id, [
            'types' => [
                DocumentType::SCORE_FOR_PAYMENT_ID,
                DocumentType::ONE_T_FORM_ID,
                DocumentType::TORG_12_ID,
                DocumentType::QUALITY_CERTIFICATE_ID,
            ]
        ]);

        $decode = $this->decodeResponse($response);

        $response->assertOk();

        self::assertIsArray($decode);
        self::assertArrayHasKey('data', $decode);
        self::assertArrayHasKey('title', $decode['data']);
        self::assertNotEmpty($decode['data']['title']);
        self::assertArrayHasKey('timestamp', $decode['data']);
        self::assertNotEmpty($decode['data']['timestamp']);
    }
}
