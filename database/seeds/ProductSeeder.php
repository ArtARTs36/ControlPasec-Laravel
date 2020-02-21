<?php

use App\Models\Product\Product;
use App\Models\Vocab\SizeOfUnit;
use App\Models\Vocab\VocabCurrency;
use App\Models\Vocab\VocabGosStandard;

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
            $product->size_of_unit_id = $this->getRelation(SizeOfUnit::class);
            $product->price = rand(150, 999999);
            $product->currency_id = $this->getRelation(VocabCurrency::class);
            $product->gos_standard_id = $this->getRelation(VocabGosStandard::class);

            $product->save();
        }
    }
}
