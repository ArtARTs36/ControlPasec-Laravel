<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Services\WorkFlowDumper;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SupplyStatusRuleController extends Controller
{
    public function diagram(WorkFlowDumper $workflow): BinaryFileResponse
    {
        return response()->download($workflow->dump());
    }
}
