<?php

namespace App\Bundles\Supply\Support;

use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithSupplierAndCustomer
{
    /**
     * Получить поставщика
     * @codeCoverageIgnore
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Получить заказчика
     * @codeCoverageIgnore
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
