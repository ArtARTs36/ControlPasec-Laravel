<?php

namespace Tests\Feature;

use App\Models\Document\Document;
use App\Services\Go\XlsxRenderGoProgram;
use Tests\BaseTestCase;

class GoProgramTest extends BaseTestCase
{
    public function testCreateByDocument()
    {
        $randomDocument = Document::where('status', Document::STATUS_NEW)
            ->inRandomOrder()
            ->get()
            ->first();

        $currentDate = new \DateTime();

        $program = XlsxRenderGoProgram::createByDocument($randomDocument, [
            'reason' => 'Счет 11 от 06.07.2016',
            'preparationDate' => $currentDate->format('d.m.Y'),
            'docNumber' => rand(1, 100),
            'items' => [
                [
                    'loop' => 1,
                    'name' => 'Мед натуральный',
                    'mount' => 51,
                    'price' => 7142
                ],
                [
                    'loop' => 2,
                    'name' => 'Хлеб серый',
                    'mount' => 115,
                    'price' => 1140
                ],
            ]
        ]);

        $executed = $program->execute();
        if ($executed !== false) {
            dump ('Документ: '. $executed);
        }

        self::assertNotFalse($executed);
    }
}
