<?php

namespace App\Bundles\Supply\Services\SupplyCreateOptions;

use App\Bundles\Supply\Contracts\SupplyCreateOption;
use App\Bundles\Supply\Repositories\ScoreForPaymentRepository;
use App\Models\Supply\ScoreForPayment;
use App\Models\Supply\Supply;

class CreateScoreForPayment implements SupplyCreateOption
{
    public const OPTION_NAME = 'score';

    protected $repository;

    public function __construct(ScoreForPaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Supply $supply): void
    {
        $this->repository->createBySupply($supply);
    }
}
