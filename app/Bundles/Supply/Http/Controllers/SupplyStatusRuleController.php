<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;
use App\Bundles\Supply\Services\WorkFlowDumper;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
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
}
