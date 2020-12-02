<?php

namespace App\Bundles\Contragent\Repositories;

use App\Based\Contracts\Repository;
use App\Models\Contragent;
use App\Models\Contragent\ContragentManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentRepository extends Repository
{
    /**
     * @todo переместить модель
     */
    protected function getModelClass(): string
    {
        return Contragent::class;
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        return $this->newQuery()->with([
            ContragentManager::PSEUDO,
            Contragent::RELATION_REQUISITES,
        ])->paginate(10, ['*'], 'ContragentsList', $page);
    }

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
