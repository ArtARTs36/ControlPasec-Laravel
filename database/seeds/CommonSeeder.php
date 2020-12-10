<?php

use App\Based\Support\CSV\CSV;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

abstract class CommonSeeder extends Seeder
{
    use WithFaker;

    protected $relations = [];

    protected $relationsCount = [];

    protected $models = [];

    public function __construct()
    {
        $this->setUpFaker();
    }

    public function loadCsvFile($file, $isTypeFileCsv = true)
    {
        $path = __DIR__ .'/data/'. $file . (($isTypeFileCsv === true) ? '.csv' : '');

        return CSV::ofFile($path);
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

    /**
     * @param $model
     * @return mixed
     */
    protected function getRelation($model)
    {
        $this->getAllObjectByRelation($model);

        $randId = rand(0, $this->relationsCount[$model]);
        if ($randId < 0) {
            $randId = 1;
        }

        return $this->relations[$model][$randId];
    }

    /**
     * @param $model
     * @param null $count
     * @return array
     */
    protected function getRelations($model, $count = null)
    {
        if ($count === null) {
            $count = rand(2, 7);
        }

        $relations = [];
        for ($i = 0; $i < $count; $i++) {
            $relations[] = $this->getRelation($model);
        }

        return array_unique($relations);
    }

    /**
     * @param $model
     * @return mixed
     */
    protected function getAllObjectByRelation($model)
    {
        if (!isset($this->relations[$model])) {
            $this->relations[$model] = $model::all()->pluck('id');
            $this->relationsCount[$model] = count($this->relations[$model]) - 1;
        }

        return $this->relations[$model];
    }

    /**
     * @param $class
     * @return Model[]
     */
    protected function getAllModels($class)
    {
        if (!isset($this->models[$class])) {
            $this->models[$class] = $class::all();
            $this->relationsCount[$class] = count($this->models[$class]) - 1;
        }

        return $this->models[$class];
    }
}
