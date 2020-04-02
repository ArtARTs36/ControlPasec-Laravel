<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreForPaymentRequest;
use App\Http\Resource\DocumentResource;
use App\Http\Responses\ActionResponse;
use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use App\ScoreForPayment;
use App\Services\Document\DocumentCreator;
use App\Services\ScoreForPaymentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ScoreForPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return ScoreForPayment::with([
            'supply' => function ($query) {
                return $query->with(['products', 'supplier', 'customer']);
            }
        ])->paginate(10, ['*'], 'ScoresList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ScoreForPaymentRequest $request
     * @return ActionResponse
     */
    public function store(ScoreForPaymentRequest $request): ActionResponse
    {
        $score = new ScoreForPayment();
        $score->fill($request->all());
        $score->save();

        return new ActionResponse(true, $score);
    }

    /**
     * Display the specified resource.
     *
     * @param ScoreForPayment $scoreForPayment
     * @return ScoreForPayment
     */
    public function show(ScoreForPayment $scoreForPayment)
    {
        return $scoreForPayment->load([
            'supply' => function ($query) {
                return $query->with(['products', 'supplier', 'customer']);
            }
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScoreForPaymentRequest $request
     * @param ScoreForPayment $scoreForPayment
     * @return ActionResponse
     */
    public function update(ScoreForPaymentRequest $request, ScoreForPayment $scoreForPayment)
    {
        $scoreForPayment->setRawAttributes($request->only(
            ['supply_id', 'contract_id', 'date']
        ));

        return new ActionResponse($scoreForPayment->save(), $scoreForPayment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ScoreForPayment $scoreForPayment
     * @return ActionResponse
     */
    public function destroy(ScoreForPayment $scoreForPayment): ActionResponse
    {
        return new ActionResponse($scoreForPayment->delete() > 0);
    }

    /**
     * Создать документ из нескольких счетов
     *
     * @param Request $request
     * @return DocumentResource
     * @throws Throwable
     */
    public function checkOrCreateDocumentOfManyScores(Request $request)
    {
        $supplies = $request->get('supplies');

        $document = DocumentCreator::getInstance(DocumentType::SCORES_FOR_PAYMENTS_ID)
            ->addScores(ScoreForPaymentService::getOrCreateBySupplies($supplies))
            ->build(true)
            ->get();

        return new DocumentResource($document);
    }
}
