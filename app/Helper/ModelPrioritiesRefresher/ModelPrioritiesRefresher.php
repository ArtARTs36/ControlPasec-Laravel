<?php

namespace App\Helper\ModelPrioritiesRefresher;

class ModelPrioritiesRefresher
{
    /** @var ModelWithPriorityInterface[] */
    private $allModels;

    /** @var ModelWithPriorityInterface */
    private $currentModel;

    /**
     * ModelPrioritiesRefresher constructor.
     * @param ModelWithPriorityInterface $currentModel
     */
    public function __construct(ModelWithPriorityInterface $currentModel)
    {
        $class = get_class($currentModel);
        $this->allModels = $class::all();
        $this->currentModel = $currentModel;
    }

    /**
     * @param int $newValue
     */
    public function refresh(int $newValue)
    {
        $this->prepareNewValue($newValue);
        $parts = $this->chunkByNumbersParts();
        $this->addValue($parts, $newValue);

        $i = 0;

        $priorities = [];
        foreach ($parts as $priority => $models) {
            /** @var ModelWithPriorityInterface $model */
            foreach ($models as $model) {
                $model->setPriority(++$i);
                $priorities[$i] = $model;
            }
        }

        foreach ($this->reloadArray($priorities) as $model) {
            $model->save();
        }
    }

    private function prepareNewValue(&$newValue)
    {
        if ($newValue > $this->allModels->count()) {
            $newValue = $this->allModels->count();
        }
    }

    private function addValue(&$parts, $newValue)
    {
        if (isset($parts[$newValue])) {
            if ($this->isTypeMinus($newValue, $this->currentModel->getPriority())) {
                array_unshift($parts[$newValue], $this->currentModel);
            } else {
                $parts[$newValue][] = $this->currentModel;
            }
        } else {
            $parts[$newValue] = [$this->currentModel];
        }
    }

    private function chunkByNumbersParts()
    {
        $parts = [];
        foreach ($this->allModels as $model) {
            if ($model->id == $this->currentModel->id) {
                continue;
            }

            $parts[$model->priority][] = $model;
        }

        return $parts;
    }

    private function isTypeMinus($newValue, $oldValue)
    {
        return ($newValue < $oldValue);
    }

    private function reloadArray($array)
    {
        $array = array_unique($array);

        ksort($array);

        return $array;
    }
}
