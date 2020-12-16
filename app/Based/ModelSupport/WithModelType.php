<?php

namespace App\Based\ModelSupport;

use App\Based\Models\ModelType;
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
