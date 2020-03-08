<?php

namespace App\Models\Product;

use App\Models\Vocab\SizeOfUnit;
use App\Models\Vocab\VocabCurrency;
use App\Models\Vocab\VocabGosStandard;
use App\Models\Vocab\VocabPackageType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property SizeOfUnit size_of_unit
 *
 * @property integer price
 * @property integer currency_id
 * @property integer gos_standard_id
 * @property VocabGosStandard gosStandard
 *
 * @property VocabPackageType package_type
 * @property int package_type_id
 *
 * @mixin Builder
 */
class Product extends Model
{
    protected $fillable = [
        'name', 'name_for_document', 'size', 'size_of_unit_id', 'price', 'currency_id'
    ];

    public function sizeOfUnit(): BelongsTo
    {
        return $this->belongsTo(SizeOfUnit::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(VocabCurrency::class);
    }

    public function gosStandard(): BelongsTo
    {
        return $this->belongsTo(VocabGosStandard::class);
    }

    public function packageType(): BelongsTo
    {
        return $this->belongsTo(VocabPackageType::class);
    }
}
