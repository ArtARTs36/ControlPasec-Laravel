<?php

namespace Tests\Bundles\Contragent\Unit;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Support\Finder;
use App\Models\Contragent;
use Tests\TestCase;

final class DaDataParserTest extends TestCase
{
    private $finder;

    public function setUp(): void
    {
        parent::setUp();

        $this->finder = app(Finder::class);
    }

    /**
     * @covers \App\Bundles\Contragent\Support\Finder::createManager
     */
    public function testCreateManager(): void
    {
        $this->expectsEvents(ExternalManagerCreated::class);

        $contragent = new Contragent();
        $contragent->id = 1;

        $data = [
            'management' => [
                'name' => 'Украинский Артем Викторович',
                'post' => 'Директор'
            ],
        ];

        $manager = $this->finder->createManager($contragent, $data);

        self::assertTrue(
            $manager->family == 'Украинский' && $manager->name == 'Артем' &&
            $manager->patronymic == 'Викторович' && $manager->contragent_id == $contragent->id
        );
    }
}
