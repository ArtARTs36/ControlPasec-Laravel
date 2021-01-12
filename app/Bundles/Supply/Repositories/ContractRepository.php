<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\Contract;
use App\Bundles\Supply\Models\Supply;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ContractRepository extends Repository
{
    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return $this->newQuery()
            ->with([Contract::RELATION_CUSTOMER, Contract::RELATION_SUPPLIER])
            ->paginate(10, ['*'], 'ContractsList', $page);
    }

    /**
     * Поиск договоров по заказчику
     */
    public function findByCustomer(int $customerId): Collection
    {
        return $this->newQuery()
            ->where(Contract::FIELD_CUSTOMER_ID, $customerId)
            ->get();
    }

    /**
     * @param Contract $contract
     * @return Contract
     */
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

    public function delete(Contract $contract): bool
    {
        return (bool) $contract->delete();
    }
}
