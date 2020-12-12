<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Bundles\Admin\Http\Requests\UpdateVariableDefinition;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class VariableDefinitionController extends Controller
{
    /**
     * Получить список переменных
     * @tag VariableDefinition
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VariableDefinition::paginate(10, ['*'], 'VariableDefinitionsList', $page);
    }

    /**
     * Показать переменную
     * @tag VariableDefinition
     */
    public function show(VariableDefinition $textDataParserDefaultVariable)
    {
        return $textDataParserDefaultVariable;
    }

    /**
     * Обновить значение переменной
     * @tag VariableDefinition
     */
    public function update(UpdateVariableDefinition $request, VariableDefinition $variableDefinition): ActionResponse
    {
        $variableDefinition->update(['value' => $request->value]);

        return new ActionResponse(true, $variableDefinition);
    }
}
