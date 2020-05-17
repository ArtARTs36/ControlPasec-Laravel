<?php

namespace App\Repositories;

use App\Models\Employee\Employee;
use Illuminate\Support\Collection;

class EmployeeRepository
{
    public static function liveFind(string $query): Collection
    {
        return Employee::query()
            ->where(function ($builder) use ($query) {
                $builder->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('patronymic', 'LIKE', "%{$query}%")
                    ->orWhere('family', 'LIKE', "%{$query}%");
            })
            ->get();
    }
}
