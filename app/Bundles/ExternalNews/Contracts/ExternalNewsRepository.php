<?php

namespace App\Bundles\ExternalNews\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ExternalNewsRepository
{
    public function paginate(int $page = 1): LengthAwarePaginator;

    /**
     * @param array<string> $links
     */
    public function getByLinks(array $links, array $columns = ['*']): Collection;

    public function chart(int $count): LengthAwarePaginator;

    public function truncate(): int;

    /**
     * @param array<array<string, mixed>> $values
     */
    public function insertOrIgnore(array $values): int;
}
