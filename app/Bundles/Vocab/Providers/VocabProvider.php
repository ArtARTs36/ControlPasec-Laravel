<?php

namespace App\Bundles\Vocab\Providers;

use App\Bundles\Vocab\Contracts\WordService;
use App\Bundles\Vocab\Services\NameInclinator;
use ArtARTs36\Morpher\Client;
use ArtARTs36\Morpher\Contracts\Morpher as MorpherContract;
use App\Bundles\Vocab\Contracts\NameInclinator as NameInclinatorContract;
use ArtARTs36\Morpher\Morpher;
use Illuminate\Support\ServiceProvider;

class VocabProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerMorpher();
        $this->app->singleton(WordService::class, \App\Bundles\Vocab\Services\WordService::class);
        $this->app->singleton(NameInclinatorContract::class, NameInclinator::class);
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
