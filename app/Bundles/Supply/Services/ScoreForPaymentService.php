<?php

namespace App\Services;

use App\Models\Supply\ScoreForPayment;
use App\Repositories\ScoreForPaymentRepository;

/**
 * Class ScoreForPaymentService
 * @package App\Services
 */
class ScoreForPaymentService
{
    /**
     * Получить или создать счета по поставкам
     *
     * @param array|int[] $supplies
     * @return array
     * @throws \Exception
     */
    public function getOrCreateBySupplies(array $supplies): array
    {
        $scores = ScoreForPaymentRepository::findBySupplies($supplies);

        $suppliesWithoutScore = array_diff($supplies, $scores->pluck('id')->all());

        if (!empty($suppliesWithoutScore)) {
            foreach ($suppliesWithoutScore as $supply) {
                $scores->push(ScoreForPayment::createBySupply($supply));
            }
        }

        return $scores->all();
    }
}
