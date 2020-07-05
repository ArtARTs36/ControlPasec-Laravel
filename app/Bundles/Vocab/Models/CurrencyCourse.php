<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CurrencyCourse
 *
 * @property int $id
 * @property int $currency_id
 * @property VocabCurrency $currency
 * @property int $nominal
 * @property float $value
 * @property string $actual_date
 */
final class CurrencyCourse extends Model
{
    public const FIELD_ACTUAL_DATE = 'actual_date';
    public const FIELD_CURRENCY_ID = 'currency_id';
    public const FIELD_NOMINAL = 'nominal';
    public const FIELD_VALUE = 'value';

    public const RELATION_CURRENCY = 'currency';

    protected $fillable = [
        self::FIELD_CURRENCY_ID,
        self::FIELD_NOMINAL,
        self::FIELD_VALUE,
        self::FIELD_ACTUAL_DATE,
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(VocabCurrency::class);
    }

    /**
     * @return float|int
     */
    public function getRatio()
    {
        return $this->value / $this->nominal;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getActualDate(): string
    {
        return (new \DateTime($this->actual_date))->format('d.m.Y');
    }
}
