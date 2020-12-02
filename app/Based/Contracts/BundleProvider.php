<?php

namespace App\Based\Contracts;

use Illuminate\Support\ServiceProvider;

abstract class BundleProvider extends ServiceProvider
{
    protected $commands = [];

    protected function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        return $this;
    }
}
