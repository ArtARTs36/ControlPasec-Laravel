<?php

namespace App\Models\Vocab;

use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabGosStandard
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property string $date_introduction
 *
 * @mixin Builder
 */
final class VocabGosStandard extends Model
{
    use WithModifier;

    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_DATE_INTRODUCTION = 'date_introduction';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
        self::FIELD_IS_ACTIVE,
        self::FIELD_DATE_INTRODUCTION,
    ];
}
