<?php

namespace App\Bundles\TechSupport\Http\Controllers;

use App\Bundles\TechSupport\Events\ReportCreated;
use App\Based\Contracts\Controller;
use App\Bundles\TechSupport\Http\Requests\StoreReport;
use App\Bundles\TechSupport\Http\Resources\ReportResource;
use App\Bundles\TechSupport\Models\TechSupportReport;
use App\Bundles\TechSupport\Repositories\TechSupportReportRepository;
use App\Bundles\User\Models\Permission;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TechSupportReportController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::TECH_SUPPORT_REPORT_SHOW_LIST,
        'read' => Permission::TECH_SUPPORT_REPORT_SET_READ,
    ];

    private $repository;

    public function __construct(TechSupportReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить список всех обращений в тех.поддержку
     * @tag TechSupportReport
     * @return AnonymousResourceCollection<ReportResource>
     */
    public function index(int $page = 1): AnonymousResourceCollection
    {
        return ReportResource::collection($this->repository->paginate($page));
    }

    /**
     * Создать обращение в тех.поддержку
     * @tag TechSupportReport
     */
    public function store(StoreReport $request): ReportResource
    {
        $report = $this->repository->create([
            TechSupportReport::FIELD_MESSAGE => $request->get(TechSupportReport::FIELD_MESSAGE),
            TechSupportReport::FIELD_IP => $request->getClientIp(),
            TechSupportReport::FIELD_USER_ID => auth()->user() ? auth()->user()->id : null,
            TechSupportReport::FIELD_AUTHOR_TITLE => $request->get(TechSupportReport::FIELD_AUTHOR_TITLE),
            TechSupportReport::FIELD_AUTHOR_CONTACT => $request->get(TechSupportReport::FIELD_AUTHOR_CONTACT),
        ]);

        event(new ReportCreated($report));

        return new ReportResource($report);
    }

    /**
     * Показать обращение в тех.поддержку
     * @tag TechSupportReport
     */
    public function show(TechSupportReport $techSupportReport): ReportResource
    {
        return new ReportResource($techSupportReport);
    }

    /**
     * Сделать обращение прочитанным
     * @tag TechSupportReport
     */
    public function read(TechSupportReport $report): ReportResource
    {
        return new ReportResource($report->read());
    }
}
