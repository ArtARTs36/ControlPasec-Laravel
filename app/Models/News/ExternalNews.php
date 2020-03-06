<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class ExternalNews
 *
 * @property int id
 * @property string title
 * @property string description
 * @property string pub_date
 * @property int source_id
 * @property ExternalNewsSource source
 * @property string link
 *
 * @mixin Builder
 */
class ExternalNews extends Model
{
    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(ExternalNewsSource::class);
    }
}
