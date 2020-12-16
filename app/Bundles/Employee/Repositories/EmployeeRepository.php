<?php

namespace App\Bundles\Employee\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Employee\Models\Employee;
use Dba\ControlTime\Scopes\CurrentWorkConditionScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EmployeeRepository extends Repository
{
    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return $this->newQuery()
            ->latest('id')
            ->paginate(10, ['*'], 'EmployeeList', $page);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function liveFind(string $query): Collection
    {
        return $this->newQuery()
            ->where(function (Builder $builder) use ($query) {
                $builder
                    ->where(Employee::FIELD_NAME, 'LIKE', "%{$query}%")
                    ->orWhere(Employee::FIELD_PATRONYMIC, 'LIKE', "%{$query}%")
                    ->orWhere(Employee::FIELD_FAMILY, 'LIKE', "%{$query}%");
            })
            ->get();
    }

    /**
     * @param int $id
     * @return Employee|null
     */
    public function fullLoad(int $id): ?Employee
    {
        return $this->newQuery()
            ->withGlobalScope(CurrentWorkConditionScope::NAME, new CurrentWorkConditionScope())
            ->find($id);
    }
}
