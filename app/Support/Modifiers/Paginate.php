<?php

namespace App\Support\Modifiers;

use Creatortsv\EloquentPipelinesModifier\Modifiers\ModifierAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

/**
 * Class Paginate
 * @package App\Support\Modifiers
 */
class Paginate extends ModifierAbstract
{
    /**
     * @inheritDoc
     */
    protected function apply(Builder $builder): Builder
    {
        if ($this->isFilledRequiredFields()) {
            Paginator::currentPageResolver(function () {
                return $this->value['page'];
            });

            $builder->getModel()->setPerPage($this->value['count']);
        }

        return $builder;
    }

    /**
     * @inheritDoc
     */
    protected function extract(string $value)
    {
        return (($json = json_decode($value, true)) !== null) ? $json : null;
    }

    /**
     * @return bool
     */
    protected function isFilledRequiredFields(): bool
    {
        return is_array($this->value) && (count(Arr::only($this->value, ['count', 'page'])) === 2);
        //return is_array($this->value) && ($k = array_keys($this->value)) && sort($k) && ['count', 'page'] === $k;
    }
}
