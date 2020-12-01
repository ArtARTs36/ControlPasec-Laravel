<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель "Курс Валюты"
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

    public const RELATION_CURRENCY = 'currency';

    protected $fillable = [
        'currency_id', 'nominal', 'value',
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
