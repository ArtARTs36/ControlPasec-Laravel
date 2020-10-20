<?php

namespace App\Bundles\Contract\Contracts;

use App\Bundles\Contract\Models\Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ContractRepository
{
    public function paginate(int $page = 1, int $count = 10): LengthAwarePaginator;

    public function findByCustomer(int $customerId): Collection;

    public function loadFull(Contract $contract): Contract;
}
