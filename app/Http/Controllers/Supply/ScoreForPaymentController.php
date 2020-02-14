<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreForPaymentRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use App\ScoreForPayment;
use App\Service\Document\DocumentService;
use App\Services\Document\DocumentBuilder;
use App\Services\ScoreForPaymentService;

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
    public function downloadDocument($supplyId)
    {
        $supply = Supply::find($supplyId);
        if (null === $supply) {
            return new ActionResponse(false);
        }

        $score = ScoreForPaymentService::getOrCreateBySupply($supply, null, null, false);
        if (empty($score->document_id)) {
            $document = DocumentService::createDocument(
                DocumentType::SCORE_FOR_PAYMENT_ID
            );

            $score->document_id = $document->id;
            $score->save();
        } else {
            $document = $score->document;
        }

        $build = DocumentBuilder::build($document);
    }
}
