<?php

namespace App\Bundles\Supply\Services\SupplyCreateOptions;

use App\Bundles\Supply\Contracts\SupplyCreateOption;
use App\Models\Supply\ScoreForPayment;
use App\Models\Supply\Supply;

class CreateScoreForPayment implements SupplyCreateOption
{
    public const OPTION_NAME = 'score';

    public function handle(Supply $supply): void
    {
        ScoreForPayment::createBySupply($supply);
    }
}
