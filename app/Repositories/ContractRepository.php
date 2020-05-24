<?php

namespace App\Repositories;

use App\Models\Contract\Contract;
use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ContractRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page = 1): LengthAwarePaginator
    {
        return Contract::query()
            ->with([Contract::RELATION_CUSTOMER, Contract::RELATION_SUPPLIER])
            ->paginate(10, ['*'], 'ContractsList', $page);
    }

    /**
     * Поиск договоров по заказчику
     *
     * @param int $customerId
     * @return Collection
     */
    public static function findByCustomer(int $customerId): Collection
    {
        return Contract::query()
            ->where(Contract::FIELD_CUSTOMER_ID, $customerId)
            ->get();
    }

    /**
     * @param Contract $contract
     * @return Contract
     */
    public static function loadFull(Contract $contract): Contract
    {
        return $contract->load([
            Contract::RELATION_CUSTOMER,
            Contract::RELATION_SUPPLIER,
            Contract::RELATION_TEMPLATE,
            Contract::RELATION_SUPPLIES => function (HasMany $query) {
                return $query->with(Supply::RELATION_CUSTOMER);
            },
        ]);
    }
}
