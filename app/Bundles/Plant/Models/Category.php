<?php

namespace App\Bundles\Plant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class Category extends Model
{
    public const FIELD_NAME = 'name';

    protected $table = 'plant_categories';

    protected $fillable = [
        self::FIELD_NAME,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }
}
