<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SyncWithExternalSystemType
 * @property int id
 * @property string name
 * @property string slug
 */
class SyncWithExternalSystemType extends Model
{
    const SLUG_CONTRAGENT_DADATA = 'contragent_dadata';
}
