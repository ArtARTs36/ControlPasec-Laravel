<?php

namespace App\Bundles\Landing\Repositories;

use App\Based\Contracts\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeedBackRepository extends Repository
{
    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return $this
            ->newQuery()
            ->paginate(10, ['*'], 'LandingFeedBacksList', $page);
    }
}
