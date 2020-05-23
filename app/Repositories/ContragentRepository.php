<?php

namespace App\Repositories;

use App\Models\Contragent;

class ContragentRepository
{
    public static function findByInn($inn)
    {
        return Contragent::query()->where('inn', $inn)->first();
    }

    public static function findByInnOrOgrn($innOrOrgn)
    {
        return Contragent::query()
            ->where(Contragent::FIELD_INN, $innOrOrgn)
            ->where(Contragent::FIELD_OGRN, $innOrOrgn)
            ->first();
    }
}
