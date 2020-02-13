<?php

use Illuminate\Database\Eloquent\Model;

class MapFind
{
    private $relationClass;

    private $field;

    private $fieldInModel;

    private $fieldInRelation;

    /** @var Model[] */
    private $list;

    public function __construct($relationClass, $field, $fieldInModel, $fieldInRelation)
    {
        $this->relationClass = $relationClass;
        $this->field = $field;
        $this->fieldInModel = $fieldInModel;
        $this->fieldInRelation = $fieldInRelation;
        $this->createList();
    }

    private function createList()
    {
        $list = $this->relationClass::all();
        foreach ($list as $value) {
            $field = $this->fieldInRelation;
            $this->list[$value->$field] = $value;
        }
    }

    public function find($value)
    {
        if (!isset($this->list[$value])) {
            return null;
        }

        return $this->list[$value]->id;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getFieldInModel()
    {
        return $this->fieldInModel;
    }
}
