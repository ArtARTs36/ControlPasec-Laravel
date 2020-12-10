<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Http\Requests\StoreProductTransportWaybill;
use App\Http\Responses\ActionResponse;
use App\Models\Supply\ProductTransportWaybill;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductTransportWaybillController extends Controller
{
    /**
     * Получить список накладных
     */
    public function index(): LengthAwarePaginator
    {
        return ProductTransportWaybill::paginate(10);
    }

    public function store(StoreProductTransportWaybill $request): JsonResource
    {
        return new JsonResource((new ProductTransportWaybill())->fillOfRequest($request));
    }

    /**
     * Показать накладную
     *
     */
    public function show(ProductTransportWaybill $waybill): JsonResource
    {
        return new JsonResource($waybill);
    }

    /**
     * Обновить накладную
     */
    public function update(StoreProductTransportWaybill $request, ProductTransportWaybill $waybill)
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
