<?php

namespace App\Repositories;

use App\Models\Employee\Employee;
use Dba\ControlTime\Scopes\CurrentWorkConditionScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EmployeeRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page = 1): LengthAwarePaginator
    {
        return Employee::query()
            ->latest('id')
            ->paginate(10, ['*'], 'EmployeeList', $page);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public static function liveFind(string $query): Collection
    {
        return Employee::query()
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
    public static function fullLoad(int $id): ?Employee
    {
        return Employee::query()
            ->withGlobalScope(CurrentWorkConditionScope::NAME, new CurrentWorkConditionScope())
            ->find($id);
    }
}
