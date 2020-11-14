<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class SyncWithExternalSystemType
 * @property int $id
 * @property string $name
 * @property string $slug
 * @mixin Builder
 */
class SyncWithExternalSystemType extends Model
{
    public const SLUG_CONTRAGENT_DADATA = 'contragent_dadata';
}
