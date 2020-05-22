<?php

namespace App\Http\Controllers\TechSupport;

use App\Events\TechSupportReportCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\TechSupport\TechSupportStoreRequest;
use App\Http\Resource\TechSupportReportResource;
use App\Models\TechSupport\TechSupportReport;
use App\Models\User\Permission;

/**
 * Class TechSupportReportController
 * @package App\Http\Controllers\TechSupport
 */
class TechSupportReportController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::TECH_SUPPORT_REPORT_SHOW_LIST,
        'read' => Permission::TECH_SUPPORT_REPORT_SET_READ,
    ];

    /**
     * @param int $page
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(int $page = 1)
    {
        return TechSupportReportResource::collection(
            TechSupportReport::query()->paginate(10, ['*'], 'TechSupportReportList', $page)
        );
    }

    /**
     * @param TechSupportStoreRequest $request
     * @return TechSupportReport
     */
    public function store(TechSupportStoreRequest $request): TechSupportReportResource
    {
        /** @var TechSupportReport $report */
        $report = TechSupportReport::query()->create([
            TechSupportReport::FIELD_MESSAGE => $request->get(TechSupportReport::FIELD_MESSAGE),
            TechSupportReport::FIELD_IP => $request->getClientIp(),
            TechSupportReport::FIELD_USER_ID => auth()->user() ? auth()->user()->id : null,
            TechSupportReport::FIELD_AUTHOR_TITLE => $request->get(TechSupportReport::FIELD_AUTHOR_TITLE),
            TechSupportReport::FIELD_AUTHOR_CONTACT => $request->get(TechSupportReport::FIELD_AUTHOR_CONTACT),
        ]);

        event(new TechSupportReportCreated($report));

        return new TechSupportReportResource($report);
    }

    /**
     * @param TechSupportReport $techSupportReport
     * @return TechSupportReportResource
     */
    public function show(TechSupportReport $techSupportReport): TechSupportReportResource
    {
        return new TechSupportReportResource($techSupportReport);
    }

    /**
     * @param TechSupportReport $report
     * @return TechSupportReport
     */
    public function read(TechSupportReport $report): TechSupportReport
    {
        return $report->read();
    }
}
