<?php

namespace App\Models\Traits;

use App\Models\Contragent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithSupplierAndCustomer
{
    /**
     * @codeCoverageIgnore
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
