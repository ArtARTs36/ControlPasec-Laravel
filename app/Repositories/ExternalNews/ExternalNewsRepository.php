<?php

namespace App\Repositories\ExternalNews;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\News\ExternalNews;

class ExternalNewsRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page = 1): LengthAwarePaginator
    {
        return ExternalNews::modify()
            ->with(ExternalNews::RELATION_SOURCE)
            ->latest('id')
            ->paginate(10, ['*'], 'ExternalNewsList', $page);
    }
}
