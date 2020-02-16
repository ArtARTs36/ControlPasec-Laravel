<?php

use App\Models\Document\DocumentType;
use App\Services\Document\DocumentCreator;

/**
 * Class DocumentSeeder
 *
 * Наполнитель для документов
 */
class DocumentSeeder extends MyDataBaseSeeder
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        }
    }

    /**
     * @param $count
     * @throws Throwable
     */
    private function randomData($count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $type = $this->getRelation(DocumentType::class);

            $document = DocumentCreator::getInstance($type);

            if ($type == DocumentType::SCORE_FOR_PAYMENT_ID) {
                $document->addScores($this->getRelation(\App\ScoreForPayment::class));
            }

            if ($type == DocumentType::SCORES_FOR_PAYMENTS_ID) {
                $document->addScores($this->getRelations(\App\ScoreForPayment::class));
            }

            $document->refreshTitle();

            $document->save();
        }
    }
}
