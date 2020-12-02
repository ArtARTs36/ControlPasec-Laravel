<?php

use App\Models\Contragent;
use App\Models\Document\DocumentType;
use App\Bundles\Product\Models\Product;
use App\Models\Supply\OneTForm;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\SupplyProduct;
use App\Models\Vocab\VocabQuantityUnit;
use App\Models\Supply\ScoreForPayment;
use App\Services\Document\DocumentCreator;

/**
 * Class SupplySeeder
 *
 * Наполнитель для поставок
 */
class SupplySeeder extends CommonSeeder
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        if (env('APP_ENV') == 'local') {
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
        $contragents = $this->getAllObjectByRelation(Contragent::class);

        foreach ($contragents as $contragent) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $supply = new App\Models\Supply\Supply();
                $supply->planned_date = $this->faker()->date();
                $supply->execute_date = $this->faker()->date();
                $supply->supplier_id = env('ONE_SUPPLIER_ID');
                $supply->customer_id = $contragent;

                $supply->save();

                $this->createRandomSupplyProducts($supply->id);
                $this->createScoreForPayment($supply->id);
                $this->createProductTransportWaybill($supply->id);
                $this->createQualityCertificate($supply->id);
                $this->createOneTForm($supply->id);
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
            $product = new SupplyProduct();
            $product->price = rand(50, 150);
            $product->quantity = rand(50, 1000);
            $product->product_id = $this->getRelation(Product::class);
            $product->supply_id = $supplyId;
            $product->quantity_unit_id = $this->getRelation(VocabQuantityUnit::class);

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
        $score = new ScoreForPayment();
        $score->date = $this->faker()->date();
        $score->supply_id = $supplyId;
        $score->order_number = $supplyId;

        $score->save();

        DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
            ->addScores($score)
            ->refreshTitle()
            ->save();

        if (rand(1, 5) == 2) {
            DocumentCreator::getInstance(DocumentType::SCORE_FOR_PAYMENT_ID)
                ->addScores([$score->id, $this->getRelation(ScoreForPayment::class)])
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
        $waybill->date = $this->faker()->date();
        $waybill->supply_id = $supplyId;

        $waybill->save();

        DocumentCreator::getInstance(DocumentType::TORG_12_ID)
            ->addProductTransportWaybills($waybill)
            ->refreshTitle()
            ->save();
    }

    /**
     * @param int $supplyId
     * @throws Throwable
     */
    private function createQualityCertificate(int $supplyId): void
    {
        $certificate = new \App\Models\Supply\QualityCertificate();
        $certificate->supply_id = $supplyId;
        $certificate->save();

        DocumentCreator::getInstance(DocumentType::QUALITY_CERTIFICATE_ID)
            ->refreshTitle()
            ->save();
    }

    /**
     * @param int $supplyId
     * @throws Throwable
     */
    private function createOneTForm(int $supplyId): void
    {
        $form = new OneTForm();
        $form->supply_id = $supplyId;
        $form->save();

        DocumentCreator::getInstance(DocumentType::ONE_T_FORM_ID)
            ->addOneTForms($form)
            ->refreshTitle()
            ->save();
    }
}
