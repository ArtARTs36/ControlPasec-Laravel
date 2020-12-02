<?php

namespace App\Bundles\Vocab\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Vocab\Console\ClearCurrencyCoursesCommand;
use App\Bundles\Vocab\Console\GetCurrencyCourseCommand;
use App\Bundles\Vocab\Console\GetCurrencyCourseOfWeekCommand;
use App\Bundles\Vocab\Services\NameInclinator;
use ArtARTs36\CbrCourseFinder\Contracts\Finder;
use ArtARTs36\Morpher\Client;
use ArtARTs36\Morpher\Morpher;
use ArtARTs36\Morpher\Contracts\Morpher as MorpherContract;
use App\Bundles\Vocab\Contracts\NameInclinator as NameInclinatorContract;

final class VocabProvider extends BundleProvider
{
    protected $commands = [
        GetCurrencyCourseOfWeekCommand::class,
        GetCurrencyCourseCommand::class,
        ClearCurrencyCoursesCommand::class,
    ];

    public function register()
    {
        $this->app->singleton(Finder::class, function () {
            return new \ArtARTs36\CbrCourseFinder\Finder(new \GuzzleHttp\Client());
        });

        $this->registerMorpher();
        $this->app->singleton(NameInclinatorContract::class, NameInclinator::class);

        $this->app->register(VocabRouteProvider::class);
    }

    protected function registerMorpher(): void
    {
        $this->app->singleton(\ArtARTs36\Morpher\Contracts\Client::class, function () {
            return new Client(new \GuzzleHttp\Client());
        });

        $this->app->singleton(MorpherContract::class, function () {
            return new Morpher($this->app->get(\ArtARTs36\Morpher\Contracts\Client::class));
        });

        $this->app->singleton(NameInclinator::class);
    }
}
