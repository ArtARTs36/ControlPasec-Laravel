<?php

namespace App\Bundles\ExternalNews\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $link
 */
class ExternalNewsSource extends Model
{
    public const TABLE = 'external_news_sources';

    public const FIELD_NAME = 'name';
    public const FIELD_LINK = 'link';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_LINK,
    ];
}
