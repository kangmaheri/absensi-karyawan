<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;
use App\Models\Employee;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return Inertia::render('attendances/Index', [
        'attendances' => Attendance::with('employee')->get(),
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return Inertia::render('attendances/Create', [
        'employees' => Employee::all()
      ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // Validasi input
      $data = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'check_in' => 'nullable|date',
        'check_out' => 'nullable|date|after_or_equal:check_in',
        'status' => 'required|string|in:Present,Permission,Sick,Absent',
      ]);

      // Buat record absensi
      $attendance = Attendance::create($data);

      // Load relasi employee agar JSON lengkap
      $attendance->load('employee');

      return redirect()->route('attendances.index')->with('success', 'Attendance created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
      return Inertia::render('attendances/Show', [
        'attendance' => $attendance->load('employee')
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
      return Inertia::render('attendances/Edit', [
        'attendance' => $attendance,
        'employees' => Employee::all(),
      ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
      // Validasi input
      $data = $request->validate([
        'employee_id' => 'sometimes|exists:employees,id',
        'check_in' => 'nullable|date',
        'check_out' => 'nullable|date|after_or_equal:check_in',
        'status' => 'sometimes|string|in:Present,Permission,Sick,Absent',
      ]);

      // Update record
      $attendance->update($data);

      // Load relasi employee agar JSON lengkap
      $attendance->load('employee');

      return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
      // Simpan info sebelum dihapus (opsional)
      $attendance->load('employee');

      // Hapus record
      $attendance->delete();

      return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully');
    }
}
