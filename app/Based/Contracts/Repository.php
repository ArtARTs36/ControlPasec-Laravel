<?php

namespace App\Based\Contracts;

use Creatortsv\EloquentPipelinesModifier\ModifierFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class Repository
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function createFromAttributes(array $attributes): Model
    {
        $model = $this->model();
        $model
            ->fill($attributes)
            ->save();

        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete() !== false;
    }

    public function forceFind(int $id): ?Model
    {
        return $this->force()->where('id', $id)->first();
    }

    public function truncate(): int
    {
        $count = $this->newQuery()->count();

        $this->newQuery()->truncate();

        return $count;
    }

    /**
     * @param array<array<string, mixed>> $values
     */
    public function insertOrIgnore(array $values): int
    {
        return $this->newQuery()->insertOrIgnore($values);
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
