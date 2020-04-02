<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\SizeOfUnit;
use Illuminate\Http\Request;

class SizeOfUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ActionResponse
     */
    public function index()
    {
        return new ActionResponse(true, SizeOfUnit::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param SizeOfUnit $sizeOfUnit
     * @return void
     */
    public function show(SizeOfUnit $sizeOfUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param SizeOfUnit $sizeOfUnit
     * @return void
     */
    public function update(Request $request, SizeOfUnit $sizeOfUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SizeOfUnit $sizeOfUnit
     * @return void
     */
    public function destroy(SizeOfUnit $sizeOfUnit)
    {
        //
    }
}
