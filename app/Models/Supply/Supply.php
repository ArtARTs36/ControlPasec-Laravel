<?php

namespace App\Models\Supply;

use App\Models\Contract\Contract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supply
 *
 * Модель "поставка"
 *
 * @property integer id
 * @property string planned_date
 * @property string executed_date
 */
class Supply extends Model
{
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
