<?php

namespace App\Based\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Admin\Models\VariableDefinition;

class VariableDefinitionRepository extends Repository
{
    protected function getModelClass(): string
    {
        return VariableDefinition::class;
    }

    public function findByName(string $name): ?VariableDefinition
    {
        return $this->newQuery()->where(VariableDefinition::FIELD_NAME, $name)->first();
    }
}
