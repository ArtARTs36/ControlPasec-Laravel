<?php

namespace App\Bundles\Contract\Repositories;

use App\Bundles\Contract\Models\Contract;
use App\Models\Supply\Supply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Bundles\Contract\Contracts\ContractRepository as MainContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class ContractRepository implements MainContract
{
    public function paginate(int $page = 1, int $count = 10): LengthAwarePaginator
    {
        return Contract::query()
            ->with([Contract::RELATION_CUSTOMER, Contract::RELATION_SUPPLIER])
            ->paginate($count, ['*'], 'ContractsList', $page);
    }

    /**
     * Поиск договоров по заказчику
     */
    public function findByCustomer(int $customerId): Collection
    {
        return Contract::query()
            ->where(Contract::FIELD_CUSTOMER_ID, $customerId)
            ->get();
    }

    public function loadFull(Contract $contract): Contract
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
