<?php

namespace App\Support\Log;

use Illuminate\Support\Collection;

/**
 * Interface LogRepositoryInterface
 * @package App\Support\Log
 */
interface LogRepositoryInterface
{
    /**
     * @return Collection
     */
    public function today(): Collection;

    /**
     * @param int $count
     * @return Collection
     */
    public function last(int $count): Collection;

    /**
     * @param string $query
     * @return Collection
     */
    public function find(string $query): Collection;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param int $count
     * @param int $page
     * @return mixed
     */
    public function page(int $count, int $page);
}
