<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $class
 */
final class ModelType extends Model
{
    public const FIELD_TITLE = 'title';
    public const FIELD_CLASS = 'class';
}
