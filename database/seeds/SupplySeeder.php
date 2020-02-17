<?php

use App\Models\Document\DocumentType;
use App\Models\Supply\ProductTransportWaybill;
use App\Services\Document\DocumentCreator;

/**
 * Class SupplySeeder
 *
 * Наполнитель для поставок
 */
class SupplySeeder extends MyDataBaseSeeder
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData();
        }
    }

    /**
     * Create Random Data ;)
     *
     * @throws Throwable
     */
    private function randomData(): void
    {
        $contragents = $this->getAllObjectByRelation(\App\Models\Contragent::class);

        foreach ($contragents as $contragent) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $supply = new App\Models\Supply\Supply();
                $supply->planned_date = $this->getFaker()->date();
                $supply->execute_date = $this->getFaker()->date();
                $supply->supplier_id = env('ONE_SUPPLIER_ID');
                $supply->customer_id = $contragent;

                $supply->save();

                $this->createRandomSupplyProducts($supply->id);
                $this->createScoreForPayment($supply->id);
                $this->createProductTransportWaybill($supply->id);
            }
        }
    }

    /**
     * Создать рандомные продукты поставки
     *
     * @param $supplyId
     */
    private function createRandomSupplyProducts($supplyId): void
    {
        $count = rand(1, 5);
        for ($i = 0; $i < $count; $i++) {
            $product = new \App\Models\Supply\SupplyProduct();
            $product->price = rand(50, 150);
            $product->mount = rand(50, 1000);
            $product->product_id = $this->getRelation(\App\Models\Product\Product::class);
            $product->supply_id = $supplyId;

            $product->save();
        }
    }

    /**
     * Создать счет на оплату
     *
     * @param $supplyId
     * @throws Exception
     * @throws Throwable
     */
    private function createScoreForPayment($supplyId): void
    {
        $score = new \App\ScoreForPayment();
        $score->date = $this->getFaker()->date();
        $score->supply_id = $supplyId;
        $score->order_number = $supplyId;

        $score->save();

        DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->addScores($score)
            ->refreshTitle()
            ->save();

        if (rand(1, 5) == 2) {
            DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
                ->addScores([$score->id, $this->getRelation(\App\ScoreForPayment::class)])
                ->refreshTitle()
                ->save();
        }
    }

    /**
     * Создать товарно транспортную накладную
     *
     * @param $supplyId
     * @throws Throwable
     */
    private function createProductTransportWaybill($supplyId): void
    {
        $waybill = new ProductTransportWaybill();
        $waybill->order_number = $supplyId;
        $waybill->date = $this->getFaker()->date();
        $waybill->supply_id = $supplyId;

        $waybill->save();

        DocumentCreator::getInstance(DocumentType::TORG_12_ID)
            ->addProductTransportWaybills($waybill)
            ->refreshTitle()
            ->save();
    }
}
