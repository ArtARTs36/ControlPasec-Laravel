<?php

use App\Models\Employee\Employee;

/**
 * Class EmployeeSeeder
 */
class EmployeeSeeder extends CommonSeeder
{
    public function run(): void
    {
        if (env('ENV_TYPE') === 'dev') {
            $this->randomData();
        }
    }

    private function randomData(int $count = 100): void
    {
        factory(Employee::class, $count)->create();
    }
}
