<?php

namespace Tests\Based\Unit;

use App\Bundles\Document\Support\XlsxRender;
use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Services\Document\DocumentBuilder;
use Tests\BaseTestCase;

final class XlsxRenderTest extends BaseTestCase
{
    /**
     * @todo уйти от поиска рандомного документа
     */
    public function testCreateByDocument(): void
    {
        /** @var Document $randomDocument */
        $randomDocument = Document::query()
            ->where('type_id', DocumentType::TORG_12_ID)
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

        $executed = XlsxRender::renderByDocument($randomDocument, $data);

        self::assertFileExists($executed);
        self::assertNotFalse($executed);
    }

    /**
     * @todo уйти от поиска рандомного документа
     */
    public function testByBuilder(): void
    {
        $randomDocument = Document::query()
            ->where('type_id', DocumentType::TORG_12_ID)
            ->inRandomOrder()
            ->get()
            ->first();

        $build = DocumentBuilder::build($randomDocument);

        self::assertNotFalse($build);
    }
}
