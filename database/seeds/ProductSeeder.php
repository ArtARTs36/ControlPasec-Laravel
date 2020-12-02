<?php

use App\Bundles\Product\Models\Product;
use App\Models\Vocab\SizeOfUnit;
use App\Bundles\Vocab\Models\VocabCurrency;
use App\Models\Vocab\VocabGosStandard;
use App\Models\Vocab\VocabPackageType;
use App\Models\Vocab\VocabQuantityUnit;

/**
 * Class ProductSeeder
 *
 * Наполнитель для товаров
 */
class ProductSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(Product::class, 'data_products');

        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $product = new App\Bundles\Product\Models\Product();
            $name = \App\Based\Support\RuFaker::product();

            $product->name = $name;
            $product->name_for_document = $name;
            $product->size = rand(10, 150);
            $product->size_of_unit_id = $this->getRelation(SizeOfUnit::class);
            $product->price = rand(150, 999999);
            $product->currency_id = $this->getRelation(VocabCurrency::class);
            $product->gos_standard_id = $this->getRelation(VocabGosStandard::class);
            $product->package_type_id = $this->getRelation(VocabPackageType::class);
            $product->quantity_unit_id = $this->getRelation(VocabQuantityUnit::class);

            $product->save();
        }
    }
}
