<?php

namespace App\Services;

use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VariableDefinitionService
 */
class VariableDefinitionService
{
    public static function inc(string $name)
    {
        $variable = self::get($name);
        $variable->value++;
        $variable->save();

        return $variable->value;
    }

    public static function dec(string $name)
    {
        $variable = self::get($name);
        $variable->value--;
        $variable->save();

        return $variable->value;
    }

    public static function getValue(string $name)
    {
        return self::get($name)->value;
    }

    public static function get(string $name): VariableDefinition
    {
        return VariableDefinition::where('name', $name)->first();
    }

    public static function getModel(string $name): Model
    {
        return VariableDefinition::with('modelType')
            ->where('name', $name)
            ->get()
            ->first()
            ->getModel();
    }
}
