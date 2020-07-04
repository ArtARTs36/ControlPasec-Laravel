<?php

namespace App\Bundles\ExternalNews\Repositories;

use App\Bundles\ExternalNews\Models\ExternalNews;
use Illuminate\Database\Eloquent\Collection;

class ExternalNewsRepository
{
    /**
     * @param array $links
     * @return Collection
     */
    public static function findByLinks(array $links): Collection
    {
        return ExternalNews::query()
            ->whereIn(ExternalNews::FIELD_LINK, $links)
            ->get();
    }
}
