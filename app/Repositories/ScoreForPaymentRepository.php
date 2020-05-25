<?php

namespace App\Repositories;

use App\ScoreForPayment;

class ScoreForPaymentRepository
{
    public static function paginate(int $page = 1)
    {
        return ScoreForPayment::with([
            ScoreForPayment::RELATION_SUPPLY => function ($query) {
                return $query->with([
                    'products',
                    'supplier',
                    'customer',
                ]);
            }
        ])->paginate(10, ['*'], 'ScoresList', $page);
    }
}
