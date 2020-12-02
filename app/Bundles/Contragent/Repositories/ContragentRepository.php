<?php

namespace App\Bundles\Contragent\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\ContragentManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ContragentRepository extends Repository
{
    public function paginate(int $page): LengthAwarePaginator
    {
        return $this->newQuery()->with([
            Contragent::RELATION_MANAGERS,
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

    public function findLikeByFields(array $fields, string $term): Collection
    {
        $query = $this->newQuery();

        foreach ($fields as $field) {
            $query->orWhere($field, 'LIKE', "%{$term}%");
        }

        return $query->get();
    }
}
