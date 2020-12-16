<?php

namespace App\Based\ModelSupport;

use App\Based\Services\VariableDefinitionService;

trait WithOrderNumber
{
    /**
     * Иницилизация порядкового номера
     */
    public function initOrderNumber(): void
    {
        if (! $this->order_number) {
            $this->order_number = app(VariableDefinitionService::class)->incByName(static::ORDER_NUMBER_TYPE);
        }
    }

    public function save(array $options = [])
    {
        $this->initOrderNumber();

        return parent::save($options);
    }
}
