<?php

namespace App\Support\Log;

use Illuminate\Support\Collection;

/**
 * Interface LogRepositoryInterface
 * @package App\Support\Log
 */
interface LogRepositoryInterface
{
    public const SORT_DESC = 1;

    public const SORT_ASC = 2;

    /**
     * @return Collection
     */
    public function today(): Collection;

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return \stdClass
     */
    public function last(): \stdClass;

    /**
     * @param int $count
     * @return Collection
     */
    public function lasts(int $count): Collection;

    /**
     * @return \stdClass
     */
    public function first(): \stdClass;

    /**
     * @param int $count
     * @return Collection
     */
    public function firsts(int $count): Collection;

    /**
     * @param string $query
     * @return Collection
     */
    public function findByWord(string $query): Collection;

    /**
     * @param \Closure $callback
     * @return Collection
     */
    public function find(\Closure $callback): Collection;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param int $count
     * @param int $page
     * @param int $sort
     * @return mixed
     */
    public function page(int $count, int $page, int $sort = self::SORT_DESC);
}
