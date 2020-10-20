<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabWord;
use App\Bundles\Vocab\Services\WordService;
use Tests\TestCase;

/**
 * @group NewTest
 */
final class WordServiceTest extends TestCase
{
    /**
     * @covers \App\Bundles\Vocab\Services\WordService::getByNominatives
     */
    public function testGetByNominatives(): void
    {
        $service = $this->make();

        $words = ['Test', 'Abcd', 'Queue'];

        //

        self::assertTrue($service->getByNominatives(...$words)->isEmpty());

        //

        for ($i = 0; $i < $expected = 3; $i++) {
            factory(VocabWord::class)->create([
                VocabWord::FIELD_NOMINATIVE => $words[$i],
            ]);
        }

        self::assertCount($expected, $service->getByNominatives(...$words));
    }

    private function make(): WordService
    {
        return app(WordService::class);
    }
}
