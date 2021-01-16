<?php

namespace App\Bundles\Plant\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Plant extends Model
{
    public const FIELD_NAME = 'name';

    protected $fillable = [
        self::FIELD_NAME,
    ];
}
