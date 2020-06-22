<?php

namespace App\Models\Traits;

use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait WithSupply
 * @package App\Models\Traits
 */
trait WithSupply
{
    /**
     * @return BelongsTo
     */
    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
