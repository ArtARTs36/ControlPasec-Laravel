<?php

namespace App\Bundles\Employee\Http\Controllers;

use App\Bundles\Employee\Http\Requests\EmployeeStoreRequest;
use App\Based\Contracts\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Repositories\EmployeeRepository;
use App\Bundles\Employee\Services\EmployeeService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class EmployeeController extends Controller
{
    private $service;

    private $repository;

    public function __construct(EmployeeService $service, EmployeeRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @param int $employeeId
     * @return Employee
     */
    public function show(int $employeeId): Employee
    {
        return $this->repository->fullLoad($employeeId);
    }

    /**
     * Обновить данные о сотруднике
     */
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        $this->service->updateWorkConditions($employee, $request->getWorkCondition());

        return $this->updateModelAndResponse($request, $employee);
    }

    /**
     * @param EmployeeStoreRequest $request
     * @return \App\Http\Responses\ActionResponse
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = $this->createModel($request, Employee::class);

        if (($wc = $request->getWorkCondition())) {
            $employee->workConditions()->create($wc);
        }

        return new ActionResponse(true, $employee);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function liveFind(string $query): Collection
    {
        return $this->repository->liveFind($query);
    }
}
