<?php

namespace App\Models\Vocab;

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
    protected $fillable = [
        'name', 'description', 'is_active', 'date_introduction'
    ];
}
