<?php

namespace Tests\Bundles\Contragent\Unit;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Support\Finder;
use App\Bundles\Contragent\Models\Contragent;
use Tests\TestCase;

final class FinderTest extends TestCase
{
    /** @var Finder  */
    private $finder;

    public function setUp(): void
    {
        parent::setUp();

        $this->finder = $this->app->make(Finder::class);
    }

    /**
     * @covers \App\Bundles\Contragent\Support\Finder::createManager
     */
    public function testCreateManager(): void
    {
        $this->expectsEvents(ExternalManagerCreated::class);

        $contragent = factory(Contragent::class)->create();

        $data = [
            'management' => [
                'name' => 'Украинский Артем Викторович',
                'post' => 'Директор'
            ],
        ];

        $manager = $this->finder->createManager($contragent, $data);

        self::assertEquals('Украинский', $manager->family);
        self::assertEquals('Артем', $manager->name);
        self::assertEquals('Викторович', $manager->patronymic);
    }
}
