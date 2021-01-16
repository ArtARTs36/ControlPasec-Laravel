<?php

namespace App\Bundles\Plant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property Category $category
 */
class Plant extends Model
{
    public const FIELD_NAME = 'name';
    public const FIELD_CATEGORY_ID = 'category_id';
    public const RELATION_CATEGORY = 'category';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_CATEGORY_ID,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
