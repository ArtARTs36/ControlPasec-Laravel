<?php

namespace App\Based\Services;

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
        $definition = $this->repository->findByName($name);

        if (! $definition) {
            throw new \RuntimeException('Variable Definition Not Founf!');
        }

        return $this->inc($definition);
    }

    public function inc(VariableDefinition $definition)
    {
        $definition->value++;
        $definition->save();

        return $definition->value;
    }
}
