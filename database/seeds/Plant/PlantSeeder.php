<?php

use App\Bundles\Plant\Models\Category;
use App\Bundles\Plant\Models\NectarProductivity;
use App\Bundles\Plant\Models\Plant;

class PlantSeeder extends CommonSeeder
{
    public function run(): void
    {
        $this->fillModel(Category::class, 'data_plant_categories');

        //

        $mapManager = new MapFindManager();
        $mapManager->add(
            Category::class,
            'category_name',
            'category_id',
            'name'
        );

        $this->fillModelWithMap(Plant::class, 'data_plants', $mapManager);

        //

        $mapManager = new MapFindManager();
        $mapManager->add(
            Plant::class,
            'plant_name',
            'plant_id',
            'name'
        );

        $this->fillModelWithMap(NectarProductivity::class, 'data_nectar_productivity', $mapManager);
    }
}
