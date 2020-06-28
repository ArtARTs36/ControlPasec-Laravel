<?php

use App\Bundles\Employee\Models\Employee;

/**
 * Class EmployeeSeeder
 */
class EmployeeSeeder extends CommonSeeder
{
    public function run(): void
    {
        if (env('APP_ENV') === 'local') {
            $this->randomData();
        }
    }

    private function randomData(int $count = 100): void
    {
        factory(Employee::class, $count)->create();
    }
}
