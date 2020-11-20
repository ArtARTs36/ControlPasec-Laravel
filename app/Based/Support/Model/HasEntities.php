<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Trait HasEntities
 * @package App\Models\Traits
 */
trait HasEntities
{
    /**
     * @return string
     */
    public function getEntityTable(): string
    {
        return $this->joiningTableSegment() . '_entity';
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
            $this->getEntityTable(),
            $this->getForeignKey(),
            'entity_id',
            null,
            null,
            true
        );
    }
}
