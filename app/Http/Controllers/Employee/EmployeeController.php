<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Models\Employee\Employee;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeService;
use Dba\ControlTime\Scopes\CurrentWorkConditionScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EmployeeController extends Controller
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return Employee::query()->latest()->paginate(10, ['*'], 'EmployeeList', $page);
    }

    /**
     * @param int $employeeId
     * @return Employee
     */
    public function show(int $employeeId): Employee
    {
        return Employee::query()
            ->withGlobalScope(CurrentWorkConditionScope::NAME, new CurrentWorkConditionScope())
            ->find($employeeId);
    }

    /**
     * @param EmployeeStoreRequest $request
     * @param Employee $employee
     * @return \App\Http\Responses\ActionResponse
     */
    public function update(EmployeeStoreRequest $request, Employee $employee)
    {
        EmployeeService::updateWorkConditions($employee, $request->getWorkCondition());

        return $this->updateModelAndResponse($request, $employee);
    }

    /**
     * @param EmployeeStoreRequest $request
     * @return \App\Http\Responses\ActionResponse
     */
    public function store(EmployeeStoreRequest $request)
    {
        return $this->createModelAndResponse($request, Employee::class);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function liveFind(string $query): Collection
    {
        return EmployeeRepository::liveFind($query);
    }
}
