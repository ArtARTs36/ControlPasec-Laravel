<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Bundles\Admin\Http\Requests\UpdateVariableDefinition;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Admin\Models\VariableDefinition;
use App\Bundles\User\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class VariableDefinitionController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VARIABLE_DEFINITIONS_LIST_VIEW,
        'update' => Permission::VARIABLE_DEFINITION_UPDATE,
    ];

    /**
     * Получить список переменных
     * @tag VariableDefinition
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VariableDefinition::query()->paginate(10, ['*'], 'VariableDefinitionsList', $page);
    }

    /**
     * Обновить значение переменной
     * @tag VariableDefinition
     */
    public function update(UpdateVariableDefinition $request, VariableDefinition $variableDefinition): ActionResponse
    {
        $variableDefinition->update(['value' => $request->input('value')]);

        return new ActionResponse(true, $variableDefinition);
    }
}
