<?php

namespace App\Based\Contracts;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

abstract class BundleProvider extends ServiceProvider
{
    protected $commands = [];

    protected $factoriesPath = '';

    protected function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        return $this;
    }

    protected function registerFactories(): self
    {
        if ($this->app->runningInConsole()) {
            $this->app->make(EloquentFactory::class)->load($this->factoriesPath);
        }

        return $this;
    }
}
