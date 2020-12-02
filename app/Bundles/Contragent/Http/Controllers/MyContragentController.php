<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyContragentRequest;
use App\Models\Contragent\MyContragent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MyContragentController extends Controller
{
    public function index(): LengthAwarePaginator
    {
        return MyContragent::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MyContragentRequest $request
     * @return void
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
     * @param MyContragentRequest $request
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
