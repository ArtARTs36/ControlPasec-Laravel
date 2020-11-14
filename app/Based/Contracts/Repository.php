<?php

namespace App\Based\Contracts;

use Illuminate\Database\Eloquent\Builder;

class Repository
{
    protected $modelClass;

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
    }

    protected function getModelClass(): string
    {
        return str_replace('Repositories', 'Models', static::class) .
            str_replace('Repository', '', class_basename(static::class));
    }

    protected function newQuery(): Builder
    {
        return $this->modelClass::query();
    }
}
