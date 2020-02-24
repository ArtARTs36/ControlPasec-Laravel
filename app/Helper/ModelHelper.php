<?php

namespace App\Helper;

class ModelHelper
{
    public static function refreshPriorities($class, $currentModel, $newValue)
    {
        $allModels = $class::all();
        $parts = [];

        if ($newValue > $allModels->count()) {
            $newValue = $allModels->count();
        }

        foreach ($allModels as $model) {
            if ($model->id == $currentModel->id) {
                continue;
            }

            $parts[$model->priority][] = $model;
        }

        if (isset($parts[$newValue])) {
            if (self::isTypeMinus($newValue, $currentModel->priority)) {
                array_unshift($parts[$newValue], $currentModel);
            } else {
                $parts[$newValue][] = $currentModel;
            }
        } else {
            $parts[$newValue] = [$currentModel];
        }

        $i = 0;

        $priorities = [];
        foreach ($parts as $priority => $models) {
            foreach ($models as $model) {
                $model->priority = ++$i;
                $priorities[$i] = $model;
            }
        }

        foreach (self::reloadArray($priorities) as $model) {
            $model->save();
        }
    }

    private static function isTypeMinus($newValue, $oldValue)
    {
        return ($newValue < $oldValue);
    }

    private static function reloadArray($array)
    {
        $array = array_unique($array);

        ksort($array);

        return $array;
    }
}
