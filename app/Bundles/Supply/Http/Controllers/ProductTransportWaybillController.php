<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Http\Requests\StoreProductTransportWaybill;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Supply\Models\ProductTransportWaybill;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProductTransportWaybillController extends Controller
{
    /**
     * Получить список накладных
     * @tag ProductTransportWaybill
     */
    public function index(): LengthAwarePaginator
    {
        return ProductTransportWaybill::paginate(10);
    }

    /**
     * @tag ProductTransportWaybill
     */
    public function store(StoreProductTransportWaybill $request): JsonResource
    {
        return new JsonResource((new ProductTransportWaybill())->fillOfRequest($request));
    }

    /**
     * Показать накладную
     * @tag ProductTransportWaybill
     */
    public function show(ProductTransportWaybill $waybill): JsonResource
    {
        return new JsonResource($waybill);
    }

    /**
     * Обновить накладную
     * @tag ProductTransportWaybill
     */
    public function update(StoreProductTransportWaybill $request, ProductTransportWaybill $waybill)
    {
        return new ActionResponse($waybill->update($request->all()), $waybill);
    }

    /**
     * Обновить накладную
     *
     * @tag ProductTransportWaybill
     */
    public function destroy(ProductTransportWaybill $waybill)
    {
        if ($waybill->delete()) {
            return response(null, 204);
        }

        return '';
    }
}
