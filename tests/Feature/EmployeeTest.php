<?php

namespace Tests\Feature;

use App\Models\Employee\Employee;
use Illuminate\Http\Response;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class EmployeeTest extends BaseTestCase
{
    private const API_PATH = '/api/employees';

    /**
     * TEST GET /api/employees/{user-id}
     */
    public function testShow(): void
    {
        $employee = factory(Employee::class)->create();

        $this->getJson(static::API_PATH . DIRECTORY_SEPARATOR . $employee->id)
            ->assertOk()
            ->assertJson($employee->toArray());
    }

    /**
     * TEST POST /api/employees/
     */
    public function testStoreByValidData(): void
    {
        $data = $this->makeEmployeeData();

        $response = $this->postJson(static::API_PATH, $data)
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('id', $response['data']);

        $employee = Employee::query()->find($response['data']['id']);
        self::assertTrue($employee->exists());
    }

    /**
     * TEST POST /api/employees/
     */
    public function testStoreByInValidData(): void
    {
        $model = new Employee();

        foreach ($model->getFillable() as $field) {
            $data = $this->makeEmployeeData();
            $data[$field] = null;

            $this->postJson(static::API_PATH, $data)
                 ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function makeEmployeeData(): array
    {
        return factory(Employee::class)->make()->toArray();
    }
}
