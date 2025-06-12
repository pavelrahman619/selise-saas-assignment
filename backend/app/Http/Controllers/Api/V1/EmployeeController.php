<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Employees")
 */
class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/employees",
     *     summary="Get all employees",
     *     tags={"Employees"},
     *     @OA\Response(response=200, description="List of employees")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Employee::with('detail', 'department');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        }

        if ($dept = $request->get('department_id')) {
            $query->where('department_id', $dept);
        }

        if ($min = $request->get('min_salary')) {
            $query->whereHas('detail', fn($q) => $q->where('salary', '>=', $min));
        }

        if ($max = $request->get('max_salary')) {
            $query->whereHas('detail', fn($q) => $q->where('salary', '<=', $max));
        }

        if ($sort = $request->get('sort')) {
            $order = $request->get('order', 'asc');
            if ($sort === 'joined_date') {
                $query->whereHas('detail')->with('detail')->join('employee_details', 'employees.id', '=', 'employee_details.employee_id')->orderBy('employee_details.joined_date', $order);
            } else {
                $query->orderBy($sort, $order);
            }
        }

        return response()->json($query->paginate(20));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/employees",
     *     summary="Create a new employee",
     *     tags={"Employees"},
     *     @OA\RequestBody(required=true),
     *     @OA\Response(response=201, description="Employee created")
     * )
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $employee = Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
        ]);

        $employee->detail()->create([
            'designation' => $data['designation'],
            'salary' => $data['salary'],
            'address' => $data['address'],
            'joined_date' => $data['joined_date'],
        ]);

        return response()->json($employee->load('detail'), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/employees/{id}",
     *     summary="Get a single employee",
     *     tags={"Employees"},
     *     @OA\Response(response=200, description="Employee found"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Employee $employee): JsonResponse
    {
        return response()->json($employee->load('detail', 'department'));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/employees/{id}",
     *     summary="Update an employee",
     *     tags={"Employees"},
     *     @OA\Response(response=200, description="Updated successfully")
     * )
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $data = $request->validated();

        // Update Employee main table
        $employee->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'department_id' => $data['department_id'],
        ]);

        // Update Employee detail table
        $employee->detail()->update([
            'designation' => $data['designation'],
            'salary' => $data['salary'],
            'address' => $data['address'],
            'joined_date' => $data['joined_date'],
        ]);

        return response()->json($employee->load('detail', 'department'));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/employees/{id}",
     *     summary="Delete an employee",
     *     tags={"Employees"},
     *     @OA\Response(response=204, description="Deleted successfully")
     * )
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->detail()->delete();
        $employee->delete();

        return response()->json(null, 204);
    }
}
