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
use Illuminate\Http\Request;

class ScoreForPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return ScoreForPayment::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScoreForPaymentRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ScoreForPayment $scoreForPayment)
    {
        return $scoreForPayment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function update(ScoreForPaymentRequest $request, ScoreForPayment $scoreForPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScoreForPayment  $scoreForPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScoreForPayment $scoreForPayment)
    {
        //
    }

    /**
     * Выгрузить документ
     *
     * @param $supplyId
     * @return ActionResponse
     * @throws \Throwable
     */
    public function checkOrCreateDocumentBySupply($supplyId)
    {
        $supply = Supply::find($supplyId);
        if (null === $supply) {
            return new ActionResponse(false);
        }

        ScoreForPaymentService::getOrCreateDocumentBySupply($supply);
    }

    /**
     * Создать документ из нескольких счетов
     *
     * @param Request $request
     * @return DocumentResource
     * @throws \Throwable
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
