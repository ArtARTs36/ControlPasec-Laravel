<?php

namespace App\Services\AdminService;

use App\Models\AdminService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdminServiceAccess
{
    /** @var string */
    private const CACHE_KEY_PREFIX = 'admin_service_access_ips_';

    /** @var AdminService */
    private $service;

    /** @var string */
    private $cacheKey;

    /**
     * AdminServiceAccess constructor.
     * @param AdminService $service
     */
    public function __construct(AdminService $service)
    {
        $this->service = $service;
        $this->cacheKey = static::CACHE_KEY_PREFIX . $service->name;
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function isAllowed(string $ip): bool
    {
        return is_int(static::getIps()->search($ip));
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function isNotAllowed(string $ip): bool
    {
        return ! $this->isAllowed($ip);
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function give(string $ip)
    {
        if ($this->isNotAllowed($ip)) {
            $ips = static::getIps()->push($ip);

            return Cache::put($this->cacheKey, $ips, Carbon::now()->addHour());
        }

        return true;
    }

    /**
     * @return Collection
     */
    public function getIps(): Collection
    {
        return Cache::get($this->cacheKey, collect());
    }
}
