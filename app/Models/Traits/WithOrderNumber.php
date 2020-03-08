<?php

namespace App\Models\Traits;

use App\Services\VariableDefinitionService;

trait WithOrderNumber
{
    /**
     * Иницилизация порядкового номера
     */
    public function initOrderNumber(): void
    {
        if (!$this->order_number) {
            $this->order_number = VariableDefinitionService::inc(self::ORDER_NUMBER_TYPE);
        }
    }
}
