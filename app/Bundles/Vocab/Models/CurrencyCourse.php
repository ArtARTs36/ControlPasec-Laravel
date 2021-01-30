<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель "Курс Валюты"
 *
 * @property int $id
 * @property int $currency_id
 * @property VocabCurrency $currency
 * @property float $nominal
 * @property float $value
 * @property \DateTimeInterface $actual_date
 */
final class CurrencyCourse extends Model
{
    public const FIELD_CURRENCY_ID = 'currency_id';
    public const FIELD_NOMINAL = 'nominal';
    public const FIELD_VALUE = 'value';
    public const FIELD_ACTUAL_DATE = 'actual_date';

    public const RELATION_CURRENCY = 'currency';

    protected $fillable = [
        'currency_id', 'nominal', 'value',
        self::FIELD_ACTUAL_DATE,
    ];

    protected $dates = [
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
        return $this->actual_date->format('d.m.Y');
    }

    protected function asDateTime($value)
    {
        if (is_string($value) && str_contains($value, '+')) {
            $parts = explode('+', $value);

            return Carbon::parse($parts[0])->addHours((int) $parts[1]);
        }

        return parent::asDateTime($value);
    }
}
