<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Models\SupplyStatusTransitionRule;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;
use App\Bundles\Supply\Services\WorkFlowDumper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SupplyStatusRuleController extends Controller
{
    public function index(SupplyStatusTransitionRuleRepository $rules): AnonymousResourceCollection
    {
        return JsonResource::collection($rules->getAllWithRelations());
    }

    public function diagram(WorkFlowDumper $workflow): BinaryFileResponse
    {
        return response()->download($workflow->dump());
    }

    public function destroy(SupplyStatusTransitionRule $supplyStatusRule): JsonResponse
    {
        $supplyStatusRule->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
