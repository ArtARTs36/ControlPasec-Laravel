<?php

namespace App\Based\Contracts;

use Creatortsv\EloquentPipelinesModifier\ModifierFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
    }

    public function forceFind(int $id): ?Model
    {
        return $this->force()->where('id', $id)->first();
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

    protected function force(): Builder
    {
        return $this->newQuery()->withoutGlobalScopes();
    }

    protected function modify(): Builder
    {
        return ModifierFactory::modifyTo($this->newQuery());
    }
}
