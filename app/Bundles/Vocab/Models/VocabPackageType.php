<?php

namespace App\Bundles\Vocab\Models;

use App\Models\Traits\WithModelType;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Class VocabTypeOfPackaging
 *
 * @property int $id
 * @property string $name
 *
 * @mixin Builder
 */
final class VocabPackageType extends Model
{
    use WithModifier;

    public const FIELD_NAME = 'name';

    protected $fillable = [
        self::FIELD_NAME,
    ];
}
