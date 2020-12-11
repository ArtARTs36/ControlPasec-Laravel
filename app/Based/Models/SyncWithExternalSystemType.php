<?php

namespace App\Based\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class SyncWithExternalSystemType extends Model
{
    public const SLUG_CONTRAGENT_DADATA = 'contragent_dadata';
}
