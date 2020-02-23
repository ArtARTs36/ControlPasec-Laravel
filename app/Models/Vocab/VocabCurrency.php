<?php

namespace App\Models\Vocab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabPriceOfUnit
 *
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 * @property int iso_code
 * @property int iso_short_name
 *
 * @mixin Builder
 */
class VocabCurrency extends Model
{
    protected $fillable = [
        'id', 'name', 'short_name', 'name_en', 'short_name_en', 'iso_code', 'iso_short_name'
    ];
}
