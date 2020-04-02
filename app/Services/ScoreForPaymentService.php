<?php

namespace App\Services;

use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use App\Models\VariableDefinition;
use App\ScoreForPayment;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentCreator;

class ScoreForPaymentService
{
    /**
     * Получить или создать счет по поставке
     *
     * @param Supply|int $supplyId
     * @param null $date
     * @param null $orderNumber
     * @return ScoreForPayment
     * @throws \Exception
     */
    public static function getOrCreateBySupply($supplyId, $date = null, $orderNumber = null): ScoreForPayment
    {
        $scoreForPayment = ScoreForPayment::where('supply_id', self::prepareSupplyId($supplyId))
            ->get()
            ->first();

        return ($scoreForPayment !== null) ? $scoreForPayment : self::create($supplyId, $date, $orderNumber);
    }

    /**
     * Создать счет
     *
     * @param $supplyId
     * @param null $date
     * @param null $orderNumber
     * @return ScoreForPayment
     * @throws \Exception
     */
    public static function create($supplyId, $date = null, $orderNumber = null): ScoreForPayment
    {
        $scoreForPayment = new ScoreForPayment();
        $scoreForPayment->order_number = $orderNumber;
        $scoreForPayment->supply_id = $supplyId;
        $scoreForPayment->date = $date ?? new \DateTime();

        $scoreForPayment->save();

        return $scoreForPayment;
    }

    /**
     * Получить или создать счета по поставкам
     *
     * @param array $supplies
     * @return array
     * @throws \Exception
     */
    public static function getOrCreateBySupplies(array $supplies): array
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
    public static function prepareSupplyId($supplyId): int
    {
        return ($supplyId instanceof Supply ? $supplyId->id : (int) $supplyId);
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

        return DocumentBuilder::build($document, $save);
    }

    /**
     * @param ScoreForPayment $score
     * @return Document
     * @throws \Exception
     * @throws \Throwable
     */
    public static function createDocumentByScore(ScoreForPayment $score)
    {
        return DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->addScores($score->id)
            ->save();
    }
}
