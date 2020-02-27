<?php

use App\Models\News\ExternalNews;
use App\Models\News\ExternalNewsSource;
use App\Services\ExternalNewsCreator;

class ExternalNewsSeeder extends CommonSeeder
{
    public function run()
    {
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        } else {
            ExternalNewsCreator::create();
        }
    }

    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $post = new ExternalNews();
            $post->title = $this->getFaker()->text(80);
            $post->description = $this->getFaker()->text;
            $post->source_id = $this->getRelation(ExternalNewsSource::class);
            $post->pub_date = $this->getFaker()->dateTime();
            $post->link = $this->getFaker()->url;
            $post->save();
        }
    }
}
