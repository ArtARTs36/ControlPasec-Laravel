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
        $parts = $this->createNumberParts($newValue);

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

    /**
     * Создать двумерный массив
     * Ключом которого будет число-приоритет
     *
     * @param int $newValue
     * @return array
     */
    private function createNumberParts(int $newValue): array
    {
        $parts = [];
        foreach ($this->allModels as $model) {
            if ($model->id == $this->currentModel->id) {
                continue;
            }

            $parts[$model->priority][] = $model;
        }

        return $this->addValue($parts, $newValue);
    }

    /**
     * Добавить значение в массив
     *
     * @param $parts
     * @param int $newValue
     * @return array
     */
    private function addValue($parts, int $newValue): array
    {
        $this->prepareNewValue($newValue);

        if (isset($parts[$newValue]) && $this->isNewPriorityMinus($newValue)) {
            array_unshift($parts[$newValue], $this->currentModel);
        } else {
            $parts[$newValue][] = $this->currentModel;
        }

        return $parts;
    }

    /**
     * Подготовить новое значение-приоритет
     *
     * @param int $newValue
     */
    private function prepareNewValue(int &$newValue): void
    {
        if ($newValue > $this->allModels->count()) {
            $newValue = $this->allModels->count();
        }
    }

    /**
     * Стал ли приоритет меньше
     *
     * @param int $newValue
     * @return bool
     */
    private function isNewPriorityMinus(int $newValue): bool
    {
        return ($newValue < $this->currentModel->getPriority());
    }

    /**
     * Перегрузить массив
     *
     * @param array $array
     * @return array
     */
    private function reloadArray(array $array): array
    {
        $array = array_unique($array);

        ksort($array);

        return $array;
    }
}
