<?php

namespace App\Based\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class ExternalSystem extends Model
{
    public const FIELD_NAME = 'name';
    public const FIELD_SLUG = 'slug';

    public const SLUG_CONTRAGENT_DADATA = 'contragent_dadata';
}
