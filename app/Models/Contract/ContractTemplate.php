<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ContractTemplate
 *
 * @property int id
 * @property string name
 * @property string contract_title
 *
 * @mixin Builder
 */
class ContractTemplate extends Model
{
    protected $fillable = [
        'id', 'name', 'contract_title'
    ];
}
