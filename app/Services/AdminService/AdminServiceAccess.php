<?php

namespace App\Services\AdminService;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AdminServiceAccess
{
    private const CACHE_KEY = 'admin_service_horizon_access_ips';

    public static function is(string $ip): bool
    {
        return is_int(static::getIps()->search($ip));
    }

    public static function give(string $ip)
    {
        if (!static::is($ip)) {
            $ips = static::getIps()->push($ip);

            return Cache::put(static::CACHE_KEY, $ips, Carbon::now()->addHour(1));
        }

        return true;
    }

    public static function getIps(): Collection
    {
        return Cache::get(static::CACHE_KEY, collect());
    }
}
