<?php

namespace App\Bundles\Supply\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Справочник статусов
 * @property int $id
 * @property string $title
 * @property string $slug
 */
class SupplyStatus extends Model
{
    public const FIELD_TITLE = 'title';
    public const FIELD_SLUG = 'slug';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_SLUG,
    ];
}
