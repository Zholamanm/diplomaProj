<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function createEmployee(array $data): Employee
    {
        return Employee::create($data);
    }

    public function updateEmployee(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee;
    }

    public function deleteEmployee(Employee $employee): void
    {
        $employee->delete();
    }
}
