<?php

namespace App;

use App\Models\Vocab\VocabCurrency;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyCourse
 *
 * @property int id
 * @property int currency_id
 * @property VocabCurrency currency
 * @property int nominal
 * @property float value
 * @property string actual_date
 */
class CurrencyCourse extends Model
{
    protected $fillable = [
        'currency_id', 'nominal', 'value', 'actual_date'
    ];

    public function currency()
    {
        return $this->belongsTo(VocabCurrency::class);
    }
}
