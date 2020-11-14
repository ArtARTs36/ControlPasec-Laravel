<?php

namespace App\Models\Traits;

use App\Models\ModelType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithModelType
{
    /**
     * @codeCoverageIgnore
     */
    public function modelType(): BelongsTo
    {
        return $this->belongsTo(ModelType::class);
    }
}
