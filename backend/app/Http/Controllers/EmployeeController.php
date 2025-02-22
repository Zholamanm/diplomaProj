<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource; 
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->input('position') . '%');
        }

        if ($request->filled('salary_min')) {
            $query->where('salary', '>=', $request->input('salary_min'));
        }

        if ($request->filled('salary_max')) {
            $query->where('salary', '<=', $request->input('salary_max'));
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(10);

        return EmployeeResource::collection($employees);
    }

    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $employee = $this->employeeService->createEmployee($request->validated());
            DB::commit();
            return new EmployeeResource($employee);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create employee.'], 500);
        }
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            DB::beginTransaction();
            $employee = $this->employeeService->updateEmployee($employee, $request->validated());
            DB::commit();
            return new EmployeeResource($employee);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update employee.'], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();
            $this->employeeService->deleteEmployee($employee);
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete employee.'], 500);
        }
    }
}
