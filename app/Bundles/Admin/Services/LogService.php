<?php

namespace App\Bundles\Admin\Services;

use App\Bundles\Admin\Contracts\LogRepositoryInterface;
use App\Bundles\Admin\Http\Resources\ShowLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LogService
{
    public const DEFAULT_COUNT = 10;

    public const CACHE_COUNT_KEY = 'security_log_count';

    private $repository;

    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function count(): int
    {
        return Cache::remember(static::CACHE_COUNT_KEY, Carbon::now()->addHour(), function () {
            return $this->repository->count();
        });
    }

    public function paginate(Collection $data, int $page = 1): array
    {
        return [
            'data' => ShowLog::collection($data),
            'total' => $this->count(),
            'current_page' => $page,
            'last_page' => (int) ($this->count() / static::DEFAULT_COUNT),
        ];
    }
}
