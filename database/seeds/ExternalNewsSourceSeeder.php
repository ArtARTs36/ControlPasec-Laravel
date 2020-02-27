<?php

use App\Models\News\ExternalNewsSource;

class ExternalNewsSourceSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(ExternalNewsSource::class, 'data_external_news_sources');
    }
}
