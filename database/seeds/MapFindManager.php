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

    public function getValues($array)
    {
        $values = [];
        foreach ($this->maps as $map) {
            foreach ($array as $key => $value) {
                $values[$map->getFieldInModel()] = $map->find($value);
            }
        }

        return $values;
    }
}
