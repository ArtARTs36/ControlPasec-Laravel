<?php

namespace App\Models;

use App\ContragentManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contragent
 *
 * @property int id
 * @property string title
 * @property string|null full_title
 * @property string|null full_title_with_opf
 * @property integer|null inn
 * @property integer|null kpp
 * @property mixed|null ogrn
 * @property integer|null okato
 * @property integer|null oktmo
 * @property mixed|null okved
 * @property mixed|null okved_type
 * @property mixed address
 * @property mixed address_postal
 * @property int status
 *
 * @mixin Builder
 */
class Contragent extends Model
{
    public function managers()
    {
        return $this->hasMany(ContragentManager::class);
    }
}
