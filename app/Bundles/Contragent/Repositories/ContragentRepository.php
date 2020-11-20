<?php

namespace App\Repositories;

use App\Models\Contragent;

/**
 * Class ContragentRepository
 * @package App\Repositories
 */
class ContragentRepository
{
    /**
     * @param $inn
     * @return Contragent|null
     */
    public static function findByInn($inn): ?Contragent
    {
        return Contragent::query()->where(Contragent::FIELD_INN, $inn)->first();
    }

    /**
     * @param $innOrOrgn
     * @return Contragent|null
     */
    public static function findByInnOrOgrn($innOrOrgn): ?Contragent
    {
        return Contragent::query()
            ->where(Contragent::FIELD_INN, $innOrOrgn)
            ->where(Contragent::FIELD_OGRN, $innOrOrgn)
            ->first();
    }
}
