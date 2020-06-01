<?php

namespace App\Support\Modifiers;

use Creatortsv\EloquentPipelinesModifier\Modifiers\ModifierAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

/**
 * Class Paginate
 * @package App\Support\Modifiers
 */
class Paginate extends ModifierAbstract
{
    const FIELDS = ['page', 'count'];

    /** @var int */
    private $count;

    /** @var int */
    private $page;

    /**
     * @inheritDoc
     */
    protected function apply(Builder $builder): Builder
    {
        if ($this->isFilledRequiredFields()) {
            Paginator::currentPageResolver(function () {
                return $this->page;
            });

            $builder->getModel()->setPerPage($this->count);
        }

        return $builder;
    }

    /**
     * @inheritDoc
     */
    protected function extract(string $value)
    {
        return (($json = json_decode($value, true)) !== null) ? $this->fill($json) : null;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function fill(array $data): self
    {
        foreach (static::FIELDS as $key) {
            $this->$key = $data[$key] ?? null;
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function isFilledRequiredFields(): bool
    {
        return ($diff = array_diff([$this->count, $this->page], [null])) && $diff[array_key_first($diff)] !== null;
    }
}
