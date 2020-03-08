<?php

namespace Tests\Feature;

use App\Services\Service\SpellingService;
use Tests\BaseTestCase;

class SpellingServiceTest extends BaseTestCase
{
    public function testRusSymbolsToEng(): void
    {
        $words = [
            'Артем' => 'Artem',
            'Сергей' => 'Sergey',
            'дом' => 'dom',
            'телефон' => 'telefon',
            'зарядка' => 'zaryadka'
        ];

        foreach ($words as $original => $except) {
            $result = SpellingService::rusSymbolsToEng($original);

            self::assertTrue($result === $except);
        }
    }
}
