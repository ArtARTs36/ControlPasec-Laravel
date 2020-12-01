<?php

namespace Tests\Bundles\ExternalNews\Unit;

use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Services\ExternalNewsCreator;
use Tests\BaseTestCase;

class ExternalNewsCreatorTest extends BaseTestCase
{
    /**
     * @covers ExternalNewsCreator::create
     */
    public function testCreate(): void
    {
        $news = app(ExternalNewsCreator::class)->create();

        self::assertIsArray($news);
        foreach ($news as $post) {
            self::assertInstanceOf(ExternalNews::class, $post);
        }
    }
}
