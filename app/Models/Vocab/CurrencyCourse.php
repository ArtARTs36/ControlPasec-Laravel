<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyCourse
 *
 * @property int id
 * @property int currency_id
 * @property int currency
 * @property int nominal
 * @property float value
 * @property string actual_date
 */
class CurrencyCourse extends Model
{
    protected $fillable = [
        'currency_id', 'nominal', 'value', 'actual_date'
    ];
}
