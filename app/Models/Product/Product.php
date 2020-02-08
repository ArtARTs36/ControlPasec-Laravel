<?php

namespace App\Models\Product;

use App\Models\Vocab\SizeOfUnit;
use App\Models\Vocab\VocabCurrency;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int id
 *
 * @property string name
 * @property string name_for_document
 *
 * @property integer size
 * @property integer size_of_unit_id
 *
 * @property integer price
 * @property integer currency_id
 */
class Product extends Model
{
    protected $fillable = [
        'name', 'name_for_document', 'size', 'size_of_unit_id', 'price', 'currency_id'
    ];

    public function sizeOfUnit()
    {
        return $this->belongsTo(SizeOfUnit::class);
    }

    public function currency()
    {
        return $this->belongsTo(VocabCurrency::class);
    }
}
