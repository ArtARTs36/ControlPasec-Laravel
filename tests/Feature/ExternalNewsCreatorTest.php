<?php

namespace Tests\Feature;

use App\Models\News\ExternalNews;
use App\Services\ExternalNewsCreator;
use Tests\BaseTestCase;

class ExternalNewsCreatorTest extends BaseTestCase
{
    public function testCreate()
    {
        $news = ExternalNewsCreator::create();

        self::assertIsArray($news);
        foreach ($news as $post) {
            self::assertInstanceOf(ExternalNews::class, $post);
        }
    }
}
