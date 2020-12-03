<?php

namespace App\Based\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    protected function model(): Model
    {
        $class = $this->modelClass;

        return new $class();
    }
}
