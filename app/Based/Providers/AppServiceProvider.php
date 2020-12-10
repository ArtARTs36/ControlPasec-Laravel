<?php

namespace App\Based\Providers;

use App\Based\Services\Calendar\Calendar;
use App\Based\Services\Calendar\SupplyModule;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
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

        $this->app->bind(Calendar::class, function () {
            return new Calendar([
                $this->app->make(SupplyModule::class),
            ]);
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
