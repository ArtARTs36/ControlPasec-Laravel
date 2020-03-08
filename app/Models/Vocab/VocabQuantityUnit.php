<?php

namespace App\Models\Vocab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabQuantityUnit
 *
 * @property int id
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 * @property int okei
 *
 * @mixin Builder
 */
final class VocabQuantityUnit extends Model
{
    protected $fillable = [
        'name', 'short_name', 'name_en', 'short_name_en', 'okei'
    ];
}
