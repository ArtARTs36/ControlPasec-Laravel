<?php

namespace App\Repositories;

use App\Models\Contragent;

class ContragentRepository
{
    public static function findByInn($inn)
    {
        return Contragent::query()->where('inn', $inn)->first();
    }
}
