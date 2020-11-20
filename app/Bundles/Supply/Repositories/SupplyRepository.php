<?php

namespace App\Repositories;

use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class SupplyRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page = null): LengthAwarePaginator
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

    /**
     * @param Supply $supply
     * @return Supply
     */
    public static function fullLoad(Supply $supply): Supply
    {
        return $supply->load([
            Supply::RELATION_PRODUCTS => function (HasMany $query) {
                return $query->with(SupplyProduct::RELATION_PARENT);
            }
        ]);
    }

    /**
     * @param int $customerId
     * @return Collection
     */
    public static function findByCustomer(int $customerId): Collection
    {
        return Supply::query()
            ->where(Supply::FIELD_CUSTOMER_ID, $customerId)
            ->get();
    }
}
