<?php

namespace App;

use App\Models\Contract\Contract;
use App\Models\Document\Document;
use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ScoreForPayment
 *
 * @property int id
 * @property integer supply_id
 * @property integer contract_id
 * @property string date
 * @property Supply supply
 * @property int order_number
 * @property Document[] documents
 *
 * @mixin Builder
 */
class ScoreForPayment extends Model
{
    protected $fillable = [
        'supply_id', 'contract_id', 'date'
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getDocument()
    {
        return $this->documents[0];
    }
}
