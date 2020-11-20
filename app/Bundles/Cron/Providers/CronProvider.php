<?php

namespace App\Bundles\Cron\Providers;

use App\Models\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Studio\Totem\Totem;

class CronProvider extends ServiceProvider
{
    public function register(): void
    {
        Totem::auth(function (Request $request) {
            return AdminService::isAllowed(AdminService::NAME_TOTEM, $request->getClientIp());
        });
    }
}
