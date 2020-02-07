<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Contract\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Contract::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractRequest $request
     * @return Contract|Response
     */
    public function store(ContractRequest $request)
    {
        return Contract::create($request->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Contract $contract
     * @return void
     */
    public function show(Contract $contract)
    {
        return $contract;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContractRequest $request
     * @param Contract $contract
     * @return void
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contract $contract
     * @return void
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
