<?php

namespace App\Based\Contracts;

use Illuminate\Database\Eloquent\Builder;

abstract class Repository
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
    }

    protected function getModelClass(): string
    {
        return str_replace(['Repositories', 'Repository'], ['Models', ''], static::class);
    }

    protected function newQuery(): Builder
    {
        return $this->modelClass::query();
    }
}
