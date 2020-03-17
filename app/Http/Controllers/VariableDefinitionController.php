<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariableDefinitionRequest;
use App\Http\Responses\ActionResponse;
use App\Models\VariableDefinition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VariableDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return VariableDefinition::paginate(10, ['*'], null, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param VariableDefinition $textDataParserDefaultVariable
     * @return VariableDefinition
     */
    public function show(VariableDefinition $textDataParserDefaultVariable)
    {
        return $textDataParserDefaultVariable;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VariableDefinitionRequest $request
     * @param VariableDefinition $variableDefinition
     * @return ActionResponse
     */
    public function update(VariableDefinitionRequest $request, VariableDefinition $variableDefinition): ActionResponse
    {
        $variableDefinition->update(['value' => $request->value]);

        return new ActionResponse(true, $variableDefinition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VariableDefinition $textDataParserDefaultVariable
     * @return void
     */
    public function destroy(VariableDefinition $textDataParserDefaultVariable)
    {
        //
    }
}
