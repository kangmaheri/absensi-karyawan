<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $employees = Employee::all();

      return Inertia::render('Employees/Index', [
          'employees' => $employees
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:employees,email',
        'position' => 'nullable|string',
      ]);

      $employee = Employee::create($data);
      return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
      return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
      $data = $request->validate([
        'name' => 'sometimes|required|string',
        'email' => 'sometimes|required|email|unique:employees,email,' . $employee->id,
        'position' => 'nullable|string',
      ]);
      $employee->update($data);

      return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
      $employee->delete();

      return response()->json(['message' => 'Employee deleted']);
    }
}
