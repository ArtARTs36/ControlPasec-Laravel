<?php

namespace App\Bundles\Supply\Support;

use App\Bundles\Supply\Models\Supply;
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
