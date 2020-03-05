<?php

namespace App\Models\Contragent;

use App\Models\Contragent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ContragentGroup
 *
 * @property int id
 * @property string name
 * @property Contragent[] contragents
 *
 * @mixin Builder
 */
class ContragentGroup extends Model
{
    public function contragents()
    {
        return $this->belongsToMany(
            Contragent::class,
            'contragent_group_related',
            'group_id',
            'contragent_id'
        );
    }
}
