<?php

namespace App\Services;

use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use App\ScoreForPayment;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentCreator;

class ScoreForPaymentService
{
    public static function getOrCreateBySupply($supplyId, $date = null, $orderNumber = null)
    {
        $scoreForPayment = ScoreForPayment::where('supply_id', self::prepareSupplyId($supplyId))
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

        $scoreForPayment->save();

        return $scoreForPayment;
    }

    public static function getOrCreateBySupplies($supplies)
    {
        $res = [];
        foreach ($supplies as $supply) {
            $res[] = self::getOrCreateBySupply($supply);
        }

        return $res;
    }

    /**
     * @param Supply|int $supplyId
     * @return int
     */
    public static function prepareSupplyId($supplyId)
    {
        return ($supplyId instanceof Supply ? $supplyId->id : $supplyId);
    }

    /**
     * @param Supply $supply
     * @param bool $save
     * @return mixed
     * @throws \Throwable
     */
    public static function getOrCreateDocumentBySupply(Supply $supply, $save = false)
    {
        $score = self::getOrCreateBySupply($supply, null, null);
        $document = $score->getDocument() ?? self::createDocumentByScore($score);

        $build = DocumentBuilder::build($document, $save);

        return $build;
    }

    /**
     * @param ScoreForPayment $score
     * @return \App\Models\Document\Document
     * @throws \Exception
     * @throws \Throwable
     */
    public static function createDocumentByScore(ScoreForPayment $score)
    {
        $document = DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->addScores($score->id)
            ->save();

        return $document;
    }
}
