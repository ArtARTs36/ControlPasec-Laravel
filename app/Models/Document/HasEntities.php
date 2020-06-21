<?php

namespace App\Models\Document;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Trait HasEntities
 * @package App\Models\Document
 */
trait HasEntities
{
    /**
     * @return MorphToMany
     */
    public function employees(): MorphToMany
    {
        return $this->morphEntities(Employee::class);
    }

    /**
     * @param string $entityClass
     * @return MorphToMany
     */
    public function morphEntities(string $entityClass): MorphToMany
    {
        return $this->morphToMany(
            $entityClass,
            'entity',
            'document_entity',
            'document_id',
            'entity_id',
            null,
            null,
            true
        );
    }
}
