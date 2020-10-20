<?php

namespace App\Providers;

use App\Bundles\Vocab\Providers\VocabProvider;
use App\Models\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Studio\Totem\Totem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->environment('production')) {
            $this->app->register(\JKocik\Laravel\Profiler\ServiceProvider::class);
        }

        $this->app->register(VocabProvider::class);

        Totem::auth(function (Request $request) {
            return AdminService::isAllowed(AdminService::NAME_TOTEM, $request->getClientIp());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
