<?php

namespace App\Bundles\ExternalNews\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ExternalNewsSource
 *
 * @property int $id
 * @property string $name
 * @property string $link
 *
 * @mixin Builder
 */
class ExternalNewsSource extends Model
{
    const TABLE = 'external_news_sources';

    protected $fillable = [
        'name', 'link',
    ];
}
