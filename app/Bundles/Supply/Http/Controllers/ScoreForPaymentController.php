<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Http\Requests\ManySuppliesRequest;
use App\Bundles\Supply\Http\Requests\StoreScore;
use App\Bundles\Document\Http\Resources\DocumentResource;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Supply\Repositories\ScoreForPaymentRepository;
use App\Bundles\Supply\Models\ScoreForPayment;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentCreator;
use App\Bundles\Supply\Services\ScoreForPaymentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

final class ScoreForPaymentController extends Controller
{
    private $repository;

    private $service;

    public function __construct(ScoreForPaymentRepository $repository, ScoreForPaymentService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @tag ScoreForPayment
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * Store a newly created resource in storage.
     * @tag ScoreForPayment
     */
    public function store(StoreScore $request): ActionResponse
    {
        $score = new ScoreForPayment();
        $score->fill($request->all());
        $score->save();

        return new ActionResponse(true, $score);
    }

    /**
     * Display the specified resource.
     *
     * @tag ScoreForPayment
     */
    public function show(ScoreForPayment $scoreForPayment)
    {
        return $scoreForPayment->load([
            ScoreForPayment::RELATION_SUPPLY => function ($query) {
                return $query->with(['products', 'supplier', 'customer']);
            }
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @tag ScoreForPayment
     */
    public function update(StoreScore $request, ScoreForPayment $scoreForPayment)
    {
        $scoreForPayment->setRawAttributes($request->only(
            ['supply_id', 'contract_id', 'date']
        ));

        return new ActionResponse($scoreForPayment->save(), $scoreForPayment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @tag ScoreForPayment
     */
    public function destroy(ScoreForPayment $scoreForPayment): ActionResponse
    {
        return new ActionResponse($scoreForPayment->delete() > 0);
    }

    /**
     * Создать документ из нескольких счетов
     *
     * @tag ScoreForPayment
     * @throws Throwable
     * @throws \ReflectionException
     */
    public function checkOrCreateDocumentOfManyScores(ManySuppliesRequest $request)
    {
        $supplies = $request->get(ManySuppliesRequest::FIELD_SUPPLIES);

        $document = DocumentCreator::getInstance(DocumentType::SCORES_FOR_PAYMENTS_ID)
            ->addScores($this->service->getOrCreateBySupplies($supplies))
            ->get();

        DocumentService::buildWithSpeedAnalyse($document);

        return new DocumentResource($document);
    }
}
