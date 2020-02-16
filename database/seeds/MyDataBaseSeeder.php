<?php

use App\Helper\CSVHelper;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

abstract class MyDataBaseSeeder extends Seeder
{
    /** @var Faker|null */
    protected $faker = null;

    protected $relations = [];

    protected $relationsCount = [];

    public function loadCsvFile($file, $isTypeFileCsv = true)
    {
        $path = __DIR__ .'/data/'. $file . (($isTypeFileCsv === true) ? '.csv' : '');

        return CSVHelper::loadFile($path);
    }

    public function getStringsOfResource($file, $isTypeFileCsv = true)
    {
        return $this->loadCsvFile($file, $isTypeFileCsv)->strings;
    }

    public function fillModel($class, $file)
    {
        foreach ($this->getStringsOfResource($file) as $string) {
            /** @var Model $model */
            $model = new $class();
            $model->fill($string->getArray());

            $model->save();
        }
    }

    public function fillModelWithMap($class, $file, MapFindManager $mapManager)
    {
        foreach ($this->getStringsOfResource($file) as $string) {
            $data = array_merge(
                $string->getArrayWithoutKeys($mapManager->getFields()),
                $mapManager->getValues($string)
            );

            /** @var Model $model */
            $model = new $class();
            $model->fill($data);

            $model->save();
        }
    }

    protected function getFaker()
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function getRelation($model)
    {
        if (!isset($this->relations[$model])) {
            $this->relations[$model] = $model::all()->pluck('id');
            $this->relationsCount[$model] = count($this->relations[$model]);
        }

        $randId = rand(0, $this->relationsCount[$model] - 2);

        return $this->relations[$model][$randId];
    }
}
