<?php

namespace App\Models\Traits;

use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithSupplierAndCustomer
{
    /**
     * Получить поставщика
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Получить заказчика
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
