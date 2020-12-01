<?php

namespace App\Bundles\Contragent\Repositories;

use App\Based\Contracts\Repository;
use App\Models\Contragent;

class ContragentRepository extends Repository
{
    public function findByInn($inn): ?Contragent
    {
        return $this->newQuery()->where(Contragent::FIELD_INN, $inn)->first();
    }

    public function findByInnOrOgrn($innOrOrgn): ?Contragent
    {
        return $this
            ->newQuery()
            ->where(Contragent::FIELD_INN, $innOrOrgn)
            ->where(Contragent::FIELD_OGRN, $innOrOrgn)
            ->first();
    }
}
