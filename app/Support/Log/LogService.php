<?php

namespace App\Support\Log;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class LogService
 * @package App\Support\Log
 */
class LogService
{
    /** @var int  */
    public const DEFAULT_COUNT = 10;

    /** @var string  */
    public const CACHE_COUNT_KEY = 'security_log_count';

    /** @var LogRepositoryInterface  */
    private $repository;

    /**
     * LogService constructor.
     * @param LogRepositoryInterface $repository
     */
    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return Cache::remember(static::CACHE_COUNT_KEY, Carbon::now()->addHour(1), function () {
            return $this->repository->count();
        });
    }

    /**
     * @param Collection $data
     * @param int $page
     * @return array
     */
    public function paginate(Collection $data, int $page = 1): array
    {
        return [
            'data' => LogResource::collection($data),
            'total' => $this->count(),
            'current_page' => $page,
            'last_page' => (int) ($this->count() / static::DEFAULT_COUNT),
        ];
    }

    public function notify(): void
    {

    }
}
