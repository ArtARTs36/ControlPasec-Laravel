<?php

namespace App\Based\Contracts;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Str;

abstract class BundleProvider extends ServiceProvider
{
    protected $commands = [];

    protected $factoriesPath = '';

    protected static $commandActivate = null;

    protected function registerCommands(): self
    {
        if ($this->isCommandActivate()) {
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

    protected function getInstances(array $classes): array
    {
        $instances = [];

        foreach ($classes as $key => $class) {
            $instances[$key] = app($class);
        }

        return $instances;
    }

    protected function isCommandActivate(): bool
    {
        if (static::$commandActivate !== null) {
            return static::$commandActivate;
        }

        return static::$commandActivate = $this->app->runningInConsole()
            || Str::contains(request()->url(), 'totem');
    }
}
