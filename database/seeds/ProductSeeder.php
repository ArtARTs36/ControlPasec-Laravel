<?php

use App\Models\Product\Product;

/**
 * Class ProductSeeder
 *
 * Наполнитель для товаров
 */
class ProductSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(Product::class, 'data_products');

        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $product = new App\Models\Product\Product();
            $name = $this->getFaker()->name;

            $product->name = $name;
            $product->name_for_document = $name;
            $product->size = rand(10, 150);
            $product->size_of_unit_id = $this->getRelation(\App\Models\Vocab\SizeOfUnit::class);
            $product->price = rand(150, 999999);
            $product->currency_id = $this->getRelation(\App\Models\Vocab\VocabCurrency::class);

            $product->save();
        }
    }
}
