<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\ScoreForPayment;
use App\Bundles\Supply\Models\Supply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ScoreForPaymentRepository extends Repository
{
    protected function getModelClass(): string
    {
        return ScoreForPayment::class;
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return ScoreForPayment::modify()->with([
            ScoreForPayment::RELATION_SUPPLY => function ($query) {
                return $query->with([
                    Supply::RELATION_PRODUCTS,
                    Supply::RELATION_SUPPLIER,
                    Supply::RELATION_CUSTOMER,
                ]);
            }
        ])->paginate(10, ['*'], 'ScoresList', $page);
    }

    /**
     * @param array<int> $supplies
     * @param array<string> $fields
     * @return Collection<ScoreForPayment>
     */
    public function findBySupplies(
        array $supplies,
        array $fields = ['id', ScoreForPayment::FIELD_SUPPLY_ID]
    ): Collection {
        return ScoreForPayment::query()
            ->distinct()
            ->latest('id')
            ->whereIn(ScoreForPayment::FIELD_SUPPLY_ID, $supplies)
            ->get($fields);
    }

    public function createBySupply(Supply $supply): ScoreForPayment
    {
        return $this->newQuery()->create([
            ScoreForPayment::FIELD_SUPPLY_ID => $supply->id,
            ScoreForPayment::FIELD_DATE => $supply->planned_date,
        ]);
    }
}
