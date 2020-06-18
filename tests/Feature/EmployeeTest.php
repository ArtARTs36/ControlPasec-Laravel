<?php

namespace Tests\Feature;

use App\Models\Employee\Employee;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class EmployeeTest extends BaseTestCase
{
    private const API_PATH = '/api/employees';

    /**
     * TEST /api/employees/{user-id}
     */
    public function testGetShow(): void
    {
        $employee = factory(Employee::class)->create();

        $this->getJson(static::API_PATH . DIRECTORY_SEPARATOR . $employee->id)
            ->assertOk()
            ->assertJson($employee->toArray());
    }
}
