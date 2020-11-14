<?php

namespace App\Bundles\ExternalNews\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\ExternalNews\Models\ExternalNews;
use Illuminate\Database\Eloquent\Collection;

class ExternalNewsRepository extends Repository
{
    public static function findByLinks(array $links): Collection
    {
        return ExternalNews::query()
            ->whereIn(ExternalNews::FIELD_LINK, $links)
            ->get();
    }

    public function truncate(): void
    {
        $this->newQuery()->truncate();
    }
}
