<?php

use App\Models\Product\Product;

class ProductSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(Product::class, 'data_products');
    }
}
