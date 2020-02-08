<?php

use App\Helper\CSVHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

abstract class MyDataBaseSeeder extends Seeder
{
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
}
