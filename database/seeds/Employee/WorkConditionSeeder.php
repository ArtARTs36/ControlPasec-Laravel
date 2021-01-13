<?php

use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Models\WorkCondition;
use Illuminate\Database\Seeder;

class WorkConditionSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            /** @var WorkCondition $condition */
            $condition = factory(WorkCondition::class)->make();
            $condition->employee_id = $employee->id;

            $condition->save();
        }
    }
}

