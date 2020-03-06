<?php

namespace App\Http\Controllers;

use App\Models\VariableDefinition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VariableDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return VariableDefinition::paginate(10);
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
     * @param \Illuminate\Http\Request $request
     * @param VariableDefinition $textDataParserDefaultVariable
     * @return void
     */
    public function update(Request $request, VariableDefinition $textDataParserDefaultVariable)
    {
        //
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
