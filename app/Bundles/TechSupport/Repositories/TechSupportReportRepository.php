<?php

namespace App\Bundles\TechSupport\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\TechSupport\Models\TechSupportReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TechSupportReportRepository extends Repository
{
    public function paginate(int $page): LengthAwarePaginator
    {
        return $this
            ->newQuery()
            ->paginate(10, ['*'], 'TechSupportReportList', $page);
    }

    public function create(array $values): TechSupportReport
    {
        return $this->newQuery()->create($values);
    }
}
