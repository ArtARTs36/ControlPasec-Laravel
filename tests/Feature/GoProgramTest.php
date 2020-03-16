<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Services\Document\DocumentBuilder;
use App\Services\Go\XlsxRenderGoProgram;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class GoProgramTest extends BaseTestCase
{
    public function testCreateByDocument()
    {
        /** @var Document $randomDocument */
        $randomDocument = Document::where('type_id', DocumentType::TORG_12_ID)
            ->inRandomOrder()
            ->get()
            ->first();

        $data = [
            'reason' => 'Счет ' . rand(1, 100) . ' от ' . $this->getFaker()->dateTime()->format('d.m.Y'),
            'preparationDate' => $this->getFaker()->dateTime()->format('d.m.Y'),
            'docNumber' => $this->getFaker()->numberBetween(1, 99),
        ];

        for ($i = 0; $i < rand(3, 10); $i++) {
            $quantity = rand(50, 10);
            $price = rand(1500, 100000);
            $data['items'][$i] = [
                'loop' => $i + 1,
                'name' => $this->getFaker()->realText(35),
                'quantity' => $quantity,
                'mountInOnePackage' => $quantity,
                'mountPlaces' => rand(1, 8),
                'price' => $price,
                'totalPrice' => $quantity * $price
            ];
        }

        $program = XlsxRenderGoProgram::createByDocument($randomDocument, $data);

        $executed = $program->execute();
        if ($executed !== false) {
            dump('Документ: ' . $executed);
        }

        self::assertNotFalse($executed);
    }

    public function testByBuilder()
    {
        $randomDocument = Document::where('type_id', DocumentType::TORG_12_ID)
            ->inRandomOrder()
            ->get()
            ->first();

        $build = DocumentBuilder::build($randomDocument);
        if ($build !== false) {
            dump('Документ: ' . $build);
        }

        self::assertNotFalse($build);
    }
}
