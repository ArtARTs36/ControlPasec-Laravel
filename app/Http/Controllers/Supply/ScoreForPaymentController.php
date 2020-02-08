<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreForPaymentRequest;
use App\ScoreForPayment;

class ScoreForPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return ScoreForPayment::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScoreForPaymentRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ScoreForPayment $scoreForPayment)
    {
        return $scoreForPayment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function update(ScoreForPaymentRequest $request, ScoreForPayment $scoreForPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScoreForPayment $scoreForPayment)
    {
        //
    }
}
