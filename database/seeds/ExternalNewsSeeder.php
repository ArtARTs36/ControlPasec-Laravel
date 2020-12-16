<?php

use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use App\Bundles\ExternalNews\Services\ExternalNewsCreator;

class ExternalNewsSeeder extends CommonSeeder
{
    public function run()
    {
        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        } else {
            app(ExternalNewsCreator::class)->create();
        }
    }

    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            factory(App\Bundles\ExternalNews\Models\ExternalNews::class)->create([
               ExternalNews::FIELD_SOURCE_ID => $this->getRelation(ExternalNewsSource::class),
            ]);
        }
    }
}
