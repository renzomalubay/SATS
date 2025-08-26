<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    //
    public function markAttendance(Request $request)
    {
        // 1. Validate the incoming request data
        $request->validate([
            'student_id' => 'required|string|max:255',
        ]);

        // 2. Get the student ID from the request
        $studentId = $request->input('student_id');

        // 3. Get today's date
        $today = Carbon::today()->toDateString();

        try {
            // 4. Check if an attendance record already exists for today
            $attendanceRecord = Attendance::where('student_id', $studentId)
                ->whereDate('attendance_date', $today)
                ->first();

            if ($attendanceRecord) {
                // Record exists, just update the timestamp
                $attendanceRecord->touch(); // This updates the `updated_at` column
                return response()->json([
                    'status' => 'success',
                    'message' => 'Attendance already marked for today.',
                    'data' => $attendanceRecord,
                ]);
            } else {
                // Record does not exist, create a new one
                $newRecord = Attendance::create([
                    'student_id' => $studentId,
                    'attendance_date' => $today,
                    'is_present' => true,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Attendance marked successfully.',
                    'data' => $newRecord,
                ]);
            }
        } catch (\Exception $e) {
            // Handle any potential database errors
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark attendance. ' . $e->getMessage(),
            ], 500);
        }
    }
}
