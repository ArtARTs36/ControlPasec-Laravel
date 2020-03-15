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
use App\Service\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use App\Services\OneTFormService;
use App\Services\SupplyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupplyController extends Controller
{
    /**
     * Получить список поставок
     *
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function index(int $page = 1): AnonymousResourceCollection
    {
        $supplies = Supply::with([
            'customer',
            'products' => function ($query) {
                return $query->with('quantityUnit');
            }
        ])->paginate(10, ['*'], null, $page);

        return SupplyResource::collection($supplies);
    }

    /**
     * Создать поставку
     *
     * @param SupplyRequest $request
     * @return ActionResponse
     */
    public function store(SupplyRequest $request): ActionResponse
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
    public function show(Supply $supply): SupplyResource
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
    public function update(SupplyRequest $request, Supply $supply): ActionResponse
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
     * @param int $supplyId
     * @return DocumentResource
     * @throws \Throwable
     */
    public function createTorg12(int $supplyId): DocumentResource
    {
        $waybill = ProductTransportWaybill::where('supply_id', $supplyId)->get()->first();
        if (null === $waybill) {
            $waybill = new ProductTransportWaybill();
            $waybill->supply_id = $supplyId;
            $waybill->date = new \DateTime();
            $waybill->save();
        }

        $document = $waybill->getDocument();

        if (!$waybill->isExistsDocument()) {
            $document = DocumentCreator::getInstance(DocumentType::TORG_12_ID)
                ->addProductTransportWaybills($waybill->id)
                ->build(true)
                ->get();
        }

        DocumentService::buildIfNotExists($document);

        return new DocumentResource($document);
    }

    /**
     * Получить документ в форме 1-Т
     * @OA\Get(
     *     path="/api/supplies/{supplyId}/oneTForm",
     *     description="Get Document T-12",
     *     tags={"Supplies Actions"},
     *     @OA\Parameter(
     *      name="supplyId",
     *      in="path",
     *      required=true,
     *     ),
     *     @OA\Response(response="default", description="Document Resource")
     * )
     * @param int $supplyId
     * @return DocumentResource
     * @throws \Throwable
     */
    public function getOneTForm(int $supplyId): DocumentResource
    {
        $form = OneTFormService::getOrCreate($supplyId);
        if (!$form->isExistsDocument()) {
            OneTFormService::createDocument($form);
        }

        DocumentService::buildIfNotExists($form->getDocument());

        return new DocumentResource($form->getDocument());
    }

    /**
     * @param int $customerId
     * @return ActionResponse
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $supplies = Supply::where('customer_id', $customerId)->get();

        return new ActionResponse((count($supplies) > 0), $supplies);
    }
}
