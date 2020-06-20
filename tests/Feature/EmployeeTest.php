<?php

namespace Tests\Feature;

use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Models\Employee\Employee;
use App\Support\RuFaker;
use Dba\ControlTime\Models\WorkCondition;
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
     */
    public function testStoreWithWorkConditions(): void
    {
        $employeeData = $this->makeEmployeeData();

        $data = array_merge($employeeData, [
            EmployeeStoreRequest::PREFIX_WORK_CONDITION => [
                WorkCondition::FIELD_RATE => $this->getFaker()->randomFloat(null, 0.1, 1),
                WorkCondition::FIELD_AMOUNT_MONTH => rand(10000, 1000000),
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
     * @return array
     */
    private function makeEmployeeData(): array
    {
        $gender = RuFaker::gender();

        return [
            Employee::FIELD_NAME => RuFaker::name($gender),
            Employee::FIELD_PATRONYMIC => RuFaker::patronymic($gender),
            Employee::FIELD_FAMILY => RuFaker::family($gender),
            Employee::FIELD_HIRED_DATE => $this->getFaker()->date()
        ];
    }
}
