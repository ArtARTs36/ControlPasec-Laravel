<?php

class MapFindManager
{
    /** @var MapFind[] */
    private $maps;

    public function add($relationClass, $field, $fieldInModel, $fieldInRelation)
    {
        $this->maps[$field] = new MapFind($relationClass, $field, $fieldInModel, $fieldInRelation);
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
