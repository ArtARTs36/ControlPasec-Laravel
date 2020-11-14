<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTransportWaybillRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Supply\ProductTransportWaybill;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductTransportWaybillController extends Controller
{
    /**
     * Получить список накладных
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return ProductTransportWaybill::query()->paginate(10);
    }

    public function store(ProductTransportWaybillRequest $request)
    {
        $waybill = new ProductTransportWaybill();
        $waybill->fill($request->toArray())
            ->save();

        return new ActionResponse(true, $waybill);
    }

    /**
     * Показать накладную
     *
     * @param ProductTransportWaybill $waybill
     * @return ProductTransportWaybill
     */
    public function show(ProductTransportWaybill $waybill)
    {
        return $waybill;
    }

    /**
     * Обновить накладную
     *
     * @param ProductTransportWaybillRequest $request
     * @param ProductTransportWaybill $waybill
     * @return ActionResponse
     */
    public function update(ProductTransportWaybillRequest $request, ProductTransportWaybill $waybill)
    {
        return new ActionResponse($waybill->update($request->all()), $waybill);
    }

    /**
     * Обновить накладную
     *
     * @param ProductTransportWaybill $waybill
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     */
    public function destroy(ProductTransportWaybill $waybill)
    {
        if ($waybill->delete()) {
            return response(null, 204);
        }

        return '';
    }
}
