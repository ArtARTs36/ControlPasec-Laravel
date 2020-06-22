<?php

use App\Bundles\ExternalNews\Models\ExternalNewsSource;

class ExternalNewsSourceSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(ExternalNewsSource::class, 'data_external_news_sources');
    }
}
