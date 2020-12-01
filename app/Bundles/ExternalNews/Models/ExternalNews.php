<?php

namespace App\Bundles\ExternalNews\Models;

use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class ExternalNews
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $pub_date
 * @property int $source_id
 * @property ExternalNewsSource $source
 * @property string $link
 *
 * @mixin Builder
 */
class ExternalNews extends Model
{
    use WithModifier;

    public const RELATION_SOURCE = 'source';

    public const FIELD_ID = 'id';
    public const FIELD_TITLE = 'title';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_SOURCE_ID = 'source_id';
    public const FIELD_PUB_DATE = 'pub_date';
    public const FIELD_LINK = 'link';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_DESCRIPTION,
    ];

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(ExternalNewsSource::class);
    }
}
