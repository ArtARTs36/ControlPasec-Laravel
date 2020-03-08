<?php

namespace App;

use App\Models\Contragent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string name
 * @property string|null patronymic
 * @property string|null family
 * @property string post
 *
 * @property int contragent_id
 */
class ContragentManager extends Model
{
    const PSEUDO = 'managers';

    /**
     * @return BelongsTo
     */
    public function contragent(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
