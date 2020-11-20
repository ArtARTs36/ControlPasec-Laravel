<?php

namespace App\Repositories;

use App\Models\Supply\ScoreForPayment;
use App\Models\Supply\Supply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class ScoreForPaymentRepository
 * @package App\Repositories
 */
class ScoreForPaymentRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page = 1): LengthAwarePaginator
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
     * @param array $supplies
     * @param array $fields
     * @return Collection
     */
    public static function findBySupplies(
        array $supplies,
        array $fields = ['id', ScoreForPayment::FIELD_SUPPLY_ID]
    ): Collection {
        return ScoreForPayment::query()
            ->distinct()
            ->latest('id')
            ->whereIn(ScoreForPayment::FIELD_SUPPLY_ID, $supplies)
            ->get($fields);
    }
}
