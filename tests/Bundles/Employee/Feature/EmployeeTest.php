<?php

namespace Tests\Bundles\Employee\Feature;

use App\Bundles\Employee\Http\Requests\EmployeeStoreRequest;
use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Models\WorkCondition;
use Illuminate\Http\Response;
use Tests\BaseTestCase;

final class EmployeeTest extends BaseTestCase
{
    private const API_PATH = '/api/employees';

    /**
     * TEST GET /api/employees/{user-id}
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeController::show
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
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeController::store
     */
    public function testStoreWithoutWorkConditions(): void
    {
        $data = $this->makeEmployeeData();

        $this->postJson(self::API_PATH, $data)
            ->assertOk()
            ->assertJson([
                'data' => $data,
            ]);
    }

    /**
     * TEST POST /api/employees/
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeController::store
     */
    public function testStoreWithWorkConditions(): void
    {
        $employeeData = $this->makeEmployeeData();

        $data = array_merge($employeeData, [
            EmployeeStoreRequest::PREFIX_WORK_CONDITION => [
                WorkCondition::FIELD_RATE => $this->getFaker()->randomFloat(null, 0.1, 1),
                WorkCondition::FIELD_AMOUNT_HOUR => rand(100, 1000),
                WorkCondition::FIELD_POSITION => $this->getFaker()->word,
        ]]);

        $response = $this->postJson(self::API_PATH, $data)
            ->assertOk()
            ->assertJson([
                'data' => $employeeData,
            ]);

        /** @var Employee $employee */
        $employee = Employee::query()->find($response['data']['id']);

        self::assertNotEmpty($employee);

        $wc = $employee->getCurrentWorkCondition();

        self::assertNotEmpty($wc);

        self::assertEquals(
            $data[EmployeeStoreRequest::PREFIX_WORK_CONDITION][WorkCondition::FIELD_RATE],
            $wc->getRate()
        );

        self::assertEquals(
            $data[EmployeeStoreRequest::PREFIX_WORK_CONDITION][WorkCondition::FIELD_POSITION],
            $wc->getPosition()
        );
    }

    /**
     * TEST POST /api/employees/
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeController::store
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
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeController::store
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

    /**
     * @covers \App\Bundles\Employee\Http\Controllers\EmployeeDocumentController::byType
     */
    public function testCreateDocumentSZVTD(): void
    {
        $employee = factory(Employee::class)->create();

        $response = $this->getJson('/api/employees/'. $employee->id . '/document/'. DocumentType::SZV_TD_ID)
            ->assertCreated()
            ->decodeResponseJson();

        /** @var Document $document */
        $document = Document::query()->find($response['data']['id']);

        self::assertTrue($document->exists);
        self::assertFileExists($document->getFullPath());
    }

    /**
     * @return array
     */
    private function makeEmployeeData(): array
    {
        return factory(Employee::class)->make()->toArray();
    }
}
