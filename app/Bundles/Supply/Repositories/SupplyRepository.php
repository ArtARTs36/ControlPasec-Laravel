<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class SupplyRepository extends Repository
{
    /**
     * @todo
     */
    protected function getModelClass(): string
    {
        return Supply::class;
    }

    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return Supply::modify()
            ->with([
                Supply::RELATION_CUSTOMER,
                Supply::RELATION_PRODUCTS => function (HasMany $query) {
                    return $query->with(SupplyProduct::RELATION_QUANTITY_UNIT);
                }
            ])
            ->paginate(null, ['*'], null, $page);
    }

    public function fullLoad(Supply $supply): Supply
    {
        return $supply->load([
            Supply::RELATION_PRODUCTS => function (HasMany $query) {
                return $query->with(SupplyProduct::RELATION_PARENT);
            }
        ]);
    }

    public function findByCustomer(int $customerId): Collection
    {
        return $this
            ->newQuery()
            ->where(Supply::FIELD_CUSTOMER_ID, $customerId)
            ->get();
    }

    /**
     * @return Collection|Supply[]
     */
    public function getWithCustomerByDates(\DateTimeInterface $start, \DateTimeInterface $end): Collection
    {
        return $this
            ->newQuery()
            ->with([Supply::RELATION_CUSTOMER => function ($query) {
                $query->select(Contragent::FIELD_TITLE);
            }])
            ->whereDate(Supply::FIELD_PLANNED_DATE, '>=', $start)
            ->whereDate(Supply::FIELD_PLANNED_DATE, '<=', $end)
            ->get([
                'id',
                Supply::FIELD_PLANNED_DATE,
            ]);
    }
}
