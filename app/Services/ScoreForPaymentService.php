<?php

namespace App\Services;

use App\Models\Supply\ScoreForPayment;
use App\Bundles\Supply\Repositories\ScoreForPaymentRepository;

/**
 * Class ScoreForPaymentService
 * @package App\Services
 */
class ScoreForPaymentService
{
    private $repository;

    public function __construct(ScoreForPaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить или создать счета по поставкам
     *
     * @param array|int[] $supplies
     * @return array
     * @throws \Exception
     */
    public function getOrCreateBySupplies(array $supplies): array
    {
        $scores = $this->repository->findBySupplies($supplies);

        $suppliesWithoutScore = array_diff($supplies, $scores->pluck('id')->all());

        if (! empty($suppliesWithoutScore)) {
            foreach ($suppliesWithoutScore as $supply) {
                $scores->push($this->repository->createBySupply($supply));
            }
        }

        return $scores->all();
    }
}
