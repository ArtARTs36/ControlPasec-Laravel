<?php

namespace App\Services;

use App\Models\Supply\Supply;
use App\ScoreForPayment;

class ScoreForPaymentService
{
    public static function getOrCreateBySupply($supplyId, $date = null, $orderNumber = null, $save = true)
    {
        if ($supplyId instanceof Supply) {
            $supplyId = $supplyId->id;
        }

        $scoreForPayment = ScoreForPayment::where('supply_id', $supplyId)
            ->get()
            ->first();

        if (null !== $scoreForPayment) {
            return $scoreForPayment;
        }

        $currentDateTime = new \DateTime();

        $scoreForPayment = new ScoreForPayment();
        $scoreForPayment->order_number = $orderNumber ?? rand(1, 99);
        $scoreForPayment->supply_id = $supplyId;
        $scoreForPayment->date = $date ?? $currentDateTime->format('Y-m-d');

        if ($save === true) {
            $scoreForPayment->save();
        }

        return $scoreForPayment;
    }
}
