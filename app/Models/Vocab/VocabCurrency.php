<?php

namespace App\Models\Vocab;

use App\Scopes\PriorityScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabCurrency
 *
 * @property int id
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 * @property int iso_code
 * @property int iso_short_name
 * @property string symbol
 * @property int priority
 *
 * @mixin Builder
 */
class VocabCurrency extends Model
{
    protected $fillable = [
        'id', 'name', 'short_name', 'name_en', 'short_name_en', 'iso_code', 'iso_short_name', 'symbol', 'priority'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PriorityScope());
    }
}
