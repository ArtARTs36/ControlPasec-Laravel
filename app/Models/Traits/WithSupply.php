<?php

namespace App\Models\Traits;

use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithSupply
{
    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
