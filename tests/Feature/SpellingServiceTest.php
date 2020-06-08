<?php

namespace Tests\Feature;

use App\Services\SpellingService;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
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
