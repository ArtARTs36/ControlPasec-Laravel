<?php

namespace App\Bundles\Supply\Support;

use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithSupply
{
    /**
     * @codeCoverageIgnore
     */
    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
