<?php

namespace App\Support\Log;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Interface LogReaderInterface
 * @package App\Support\Log
 */
interface LogReaderInterface
{
    /**
     * @return Collection
     */
    public function getFiles(): Collection;

    /**
     * @param string $path
     * @return Collection
     */
    public function read(string $path): Collection;

    /**
     * @param string $path
     * @return string
     */
    public function readRaw(string $path): string;

    /**
     * @param Carbon $date
     * @return Collection
     */
    public function readByDate(Carbon $date): Collection;

    /**
     * @param string $data
     * @return Collection
     */
    public function prepare(string $data): Collection;
}
