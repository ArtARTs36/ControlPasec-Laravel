<?php

namespace App;

use App\Models\Vocab\VocabCurrency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
final class CurrencyCourse extends Model
{
    protected $fillable = [
        'currency_id', 'nominal', 'value', 'actual_date'
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(VocabCurrency::class);
    }
}
