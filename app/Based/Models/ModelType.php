<?php

namespace App\Based\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $title
 * @property string $class
 *
 * @mixin Builder
 */
final class ModelType extends Model
{
    public const FIELD_CLASS = 'class';
}
