<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'index'])->name('students.index');
Route::get('/scanner', [StudentController::class, 'scanner'])->name('students.scanner');

Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
