<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of students you want to create
        $numberOfStudents = 10;

        // Loop to create multiple student records
        for ($i = 0; $i < $numberOfStudents; $i++) {
            // Generate a unique student ID
            $studentId = 'S' . now()->year . Str::padLeft($i + 1, 4, '0');

            // Data to be encoded in the QR code. You can use any data you need.
            $qrData = json_encode([
                'student_id' => $studentId,
                'name' => 'Student ' . ($i + 1),
            ]);

            // Generate the QR code as an SVG string
            $qrCode = QrCode::size(250)
                            ->format('svg')
                            ->generate($qrData);

            // Create the student record in the database
            Student::create([
                'first_name' => 'Student ' . ($i + 1),
                'last_name' => 'Test',
                'student_id' => $studentId,
                'qr_code' => $qrCode, // Store the generated QR code string
            ]);
        }
    }
}
