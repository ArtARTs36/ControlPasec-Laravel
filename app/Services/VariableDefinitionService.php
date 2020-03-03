<?php

namespace App\Services;

use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VariableDefinitionService
 *
 * @method
 */
class VariableDefinitionService
{
    public static function inc($name)
    {
        $variable = self::get($name);
        $variable->value++;
        $variable->save();

        return $variable->value;
    }

    public static function dec($name)
    {
        $variable = self::get($name);
        $variable->value--;
        $variable->save();

        return $variable->value;
    }

    public static function getValue($name)
    {
        return VariableDefinition::where('name', $name)->get()->first()->value;
    }

    public static function get($name): VariableDefinition
    {
        return VariableDefinition::where('name', $name)->get()->first();
    }

    public static function getModel($name): Model
    {
        return VariableDefinition::with('modelType')
            ->where('name', $name)
            ->get()
            ->first()
            ->getModel();
    }
}
