<?php

namespace App\Services;

use App\Based\Repositories\VariableDefinitionRepository;
use App\Bundles\Admin\Models\VariableDefinition;

class VariableDefinitionService
{
    protected $repository;

    public function __construct(VariableDefinitionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function incByName(string $name)
    {
        return $this->inc($this->repository->findByName($name));
    }

    public function inc(VariableDefinition $definition)
    {
        $definition->value++;
        $definition->save();

        return $definition->value;
    }
}
