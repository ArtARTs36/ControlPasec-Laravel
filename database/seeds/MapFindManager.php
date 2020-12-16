<?php

use App\Based\Support\CSV\CSVString;

class MapFindManager
{
    /** @var MapFind[] */
    private $maps;

    public function add($relationClass, $fieldInFile, $fieldInModel, $fieldInRelation)
    {
        $this->maps[$fieldInFile] = new MapFind($relationClass, $fieldInFile, $fieldInModel, $fieldInRelation);
    }

    public function getFields()
    {
        return array_keys($this->maps);
    }

    public function getValues(CSVString $str)
    {
        $values = [];

        foreach ($this->maps as $map) {
            $slug = $str->getByKey($map->getField());

            $values[$map->getFieldInModel()] = $map->find($slug);
        }

        return $values;
    }
}
