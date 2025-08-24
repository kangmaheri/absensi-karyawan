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
      return Inertia::render('Employees/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:employees,email',
        'position' => 'required|string|max:255',
      ]);

      Employee::create($request->only('name','email','position'));

      return redirect()->route('employees.index')->with('success', 'Karyawan ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
      return Inertia::render('Employees/Show', [
        'employee' => $employee
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
      return Inertia::render('Employees/Edit', [
        'employee' => $employee
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
      $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:employees,email,'.$employee->id,
        'position' => 'required|string|max:255',
      ]);

      $employee->update($request->only('name','email','position'));

      return redirect()->route('employees.index')->with('success', 'Karyawan diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
      $employee->delete();

      return redirect()->route('employees.index')->with('success', 'Karyawan dihapus');
    }
}
