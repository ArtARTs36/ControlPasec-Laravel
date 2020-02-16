<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplyRequest;
use App\Http\Resource\DocumentResource;
use App\Http\Resource\SupplyResource;
use App\Http\Responses\ActionResponse;
use App\Models\Document\DocumentType;
use App\Models\Supply\ProductTransportWaybill;
use App\Models\Supply\Supply;
use App\Services\Document\DocumentCreator;
use App\Services\SupplyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupplyController extends Controller
{
    /**
     * Получить список поставок
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $supplies = Supply::with(['customer', 'products'])->paginate(10);

        return SupplyResource::collection($supplies);
    }

    /**
     * Создать поставку
     *
     * @param SupplyRequest $request
     * @return ActionResponse
     */
    public function store(SupplyRequest $request)
    {
        $supply = new Supply();
        $supply->supplier_id = env('ONE_SUPPLIER_ID');
        $supply->fill($request->all());
        $supply->save();

        SupplyService::checkProductsInSupply($request, $supply->id);

        return new ActionResponse(true, $supply);
    }

    /**
     * Открыть поставку
     *
     * @param Supply $supply
     * @return SupplyResource
     */
    public function show(Supply $supply)
    {
        return new SupplyResource($supply->load([
            'products' => function ($query) {
                return $query->with('parent');
            }
        ]));
    }

    /**
     * Обновить данные о поставке
     *
     * @param SupplyRequest $request
     * @param Supply $supply
     * @return ActionResponse
     */
    public function update(SupplyRequest $request, Supply $supply)
    {
        $requestData = $request->all();
        $supply->update($requestData);

        SupplyService::checkProductsInSupply($requestData);

        return new ActionResponse(true, $supply);
    }

    /**
     * @param Supply $supply
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();
    }

    /**
     * @param $supplyId
     * @return DocumentResource
     * @throws \Throwable
     */
    public function createTorg12($supplyId)
    {
        $waybill = ProductTransportWaybill::where('supply_id', $supplyId)->get()->first();
        if (null === $waybill) {
            $waybill = new ProductTransportWaybill();
            $waybill->order_number = 1;
            $waybill->supply_id = $supplyId;
            $waybill->date = new \DateTime();
            $waybill->save();
        }

        $document = $waybill->getDocument();

        if (null === $document) {
            $document = DocumentCreator::getInstance(DocumentType::TORG_12_ID)
                ->addProductTransportWaybills($waybill->id)
                ->build(true)
                ->get();
        }

        return new DocumentResource($document);
    }

    /**
     * @param $customerId
     * @return ActionResponse
     */
    public function findByCustomer($customerId)
    {
        $supplies = Supply::where('customer_id', $customerId)->get();

        return new ActionResponse((count($supplies) > 0), $supplies);
    }
}
