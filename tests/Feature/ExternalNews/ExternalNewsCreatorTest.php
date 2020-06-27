<?php

namespace Tests\Feature\ExternalNews;

use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Services\ExternalNewsCreator;
use Tests\BaseTestCase;

class ExternalNewsCreatorTest extends BaseTestCase
{
    public function testCreate(): void
    {
        $news = ExternalNewsCreator::create();

        self::assertIsArray($news);
        foreach ($news as $post) {
            self::assertInstanceOf(ExternalNews::class, $post);
        }
    }
}
