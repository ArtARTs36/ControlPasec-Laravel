<?php

namespace App;

use App\Models\Contragent;
use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }
}
