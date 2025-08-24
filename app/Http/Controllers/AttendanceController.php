<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Inertia\Inertia;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'check_in' => 'nullable|date',
        'check_out' => 'nullable|date',
        'status' => 'required|string',
      ]);

      $attendance = Attendance::create($data);

      return response()->json($attendance, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return response()->json($attendance->load('employee'));
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
    public function update(Request $request, Attendance $attendance)
    {
      $data = $request->validate([
        'employee_id' => 'sometimes|exists:employees,id',
        'check_in' => 'nullable|date',
        'check_out' => 'nullable|date',
        'status' => 'sometimes|string',
      ]);

      $attendance->update($data);

      return response()->json($attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted']);
    }
}
