<?php

namespace App\Http\Controllers\Contragent;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyContragentRequest;
use App\Models\Contragent\MyContragent;

class MyContragentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return MyContragent::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MyContragentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param MyContragent $myContragent
     * @return MyContragent
     */
    public function show(MyContragent $myContragent)
    {
        return $myContragent;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param MyContragent $myContragent
     * @return void
     */
    public function update(MyContragentRequest $request, MyContragent $myContragent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MyContragent $myContragent
     * @return void
     */
    public function destroy(MyContragent $myContragent)
    {
        $myContragent->delete();
    }
}
