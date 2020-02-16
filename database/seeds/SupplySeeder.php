<?php

/**
 * Class SupplySeeder
 *
 * Наполнитель для поставок
 */
class SupplySeeder extends MyDataBaseSeeder
{
    public function run()
    {
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        }
    }

    /**
     * Create Random Data ;)
     *
     * @param int $count
     */
    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $supply = new App\Models\Supply\Supply();
            $supply->planned_date = $this->getFaker()->date();
            $supply->execute_date = $this->getFaker()->date();
            $supply->supplier_id = env('ONE_SUPPLIER_ID');
            $supply->customer_id = $this->getRelation(\App\Models\Contragent::class);

            $supply->save();

            $this->createRandomSupplyProducts($supply->id);
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
}
