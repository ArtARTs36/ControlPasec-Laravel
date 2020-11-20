<?php

namespace App\Providers;

use App\Bundles\Contract\Providers\ContractProvider;
use App\Bundles\Contragent\Providers\ContragentProvider;
use App\Bundles\Cron\Providers\CronProvider;
use App\Bundles\ExternalNews\Providers\ExternalNewsProvider;
use App\Bundles\Vocab\Providers\VocabProvider;
use Illuminate\Support\ServiceProvider;

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
        $this->app->register(ContractProvider::class);
        $this->app->register(ExternalNewsProvider::class);
        $this->app->register(CronProvider::class);
        $this->app->register(ContragentProvider::class);
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
