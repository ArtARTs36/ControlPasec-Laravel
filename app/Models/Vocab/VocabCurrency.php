<?php

namespace App\Models\Vocab;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VocabPriceOfUnit
 *
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 */
class VocabCurrency extends Model
{
    protected $fillable = [
        'id', 'name', 'short_name', 'name_en', 'short_name_en'
    ];
}
