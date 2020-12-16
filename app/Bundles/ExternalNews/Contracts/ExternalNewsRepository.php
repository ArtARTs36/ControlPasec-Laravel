<?php

namespace App\Bundles\ExternalNews\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ExternalNewsRepository
{
    public function paginate(int $page = 1): LengthAwarePaginator;

    public function getByLinks(array $links): Collection;
}
