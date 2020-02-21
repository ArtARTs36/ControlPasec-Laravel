<?php

namespace App\Http\Controllers;

use App\Models\Vocab\VocabGosStandard;
use Illuminate\Http\Request;

class VocabGosStandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return VocabGosStandard::paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param VocabGosStandard $vocabGosStandard
     * @return void
     */
    public function show(VocabGosStandard $vocabGosStandard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param VocabGosStandard $vocabGosStandard
     * @return void
     */
    public function update(Request $request, VocabGosStandard $vocabGosStandard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VocabGosStandard $vocabGosStandard
     * @return void
     */
    public function destroy(VocabGosStandard $vocabGosStandard)
    {
        //
    }
}
