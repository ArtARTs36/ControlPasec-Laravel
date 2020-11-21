<?php

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

    public function getValues(\App\Helper\CSV\CSVString $CSVString)
    {
        $values = [];

        foreach ($this->maps as $map) {
            $slug = $CSVString->getByKey($map->getField());

            $values[$map->getFieldInModel()] = $map->find($slug);
        }

        return $values;
    }
}
