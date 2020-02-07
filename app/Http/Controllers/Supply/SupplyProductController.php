<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplyProductRequest;
use App\Models\Supply\SupplyProduct;
use Illuminate\Http\Request;

class SupplyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplyProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param SupplyProduct $supplyProduct
     * @return void
     */
    public function show(SupplyProductRequest $supplyProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param SupplyProduct $supplyProduct
     * @return void
     */
    public function update(SupplyProductRequest $request, SupplyProduct $supplyProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SupplyProduct $supplyProduct
     * @return void
     */
    public function destroy(SupplyProduct $supplyProduct)
    {
        //
    }
}
