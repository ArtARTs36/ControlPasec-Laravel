<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Responses\ActionResponse;
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
        return Contract::with(['customer', 'supplier'])->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractRequest $request
     * @return Contract|Response
     */
    public function store(ContractRequest $request)
    {
        $contract = new Contract();
        $contract->fill($request->toArray());
        $contract->supplier_id = env('ONE_SUPPLIER_ID');
        $contract->save();

        return $contract;
    }

    /**
     * Display the specified resource.
     *
     * @param Contract $contract
     * @return Contract
     */
    public function show(Contract $contract)
    {
        return $contract->load([
            'customer',
            'supplier',
            'supplies'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContractRequest $request
     * @param Contract $contract
     * @return ActionResponse
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        return new ActionResponse($contract->update($request->all()), $contract);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contract $contract
     * @return bool|void
     */
    public function destroy(Contract $contract)
    {
        if ($contract->delete()) {
            return response(null, 204);
        }

        return '';
    }

    /**
     * Поиск договоров по заказчику
     *
     * @param $customerId
     * @return ActionResponse
     */
    public function findByCustomer($customerId)
    {
        $contracts = Contract::where('customer_id', $customerId)->get();

        return new ActionResponse((count($contracts) > 0), $contracts);
    }
}
