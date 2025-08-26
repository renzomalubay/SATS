<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentsQrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define the number of students you want to create
        $numberOfStudents = 10;

        // Loop to create a set of students and their QR codes
        for ($i = 0; $i < $numberOfStudents; $i++) {

            // Step 1: Create the student record first.
            // Note: We leave qr_code_id as null for now because it doesn't exist yet.
            $student = Student::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'student_id' => $faker->unique()->randomNumber(8), // Generate a unique 8-digit student ID
            ]);

            // Data to be encoded in the QR code. We use the newly created student's ID.
            $qrData = json_encode([
                'student_id' => $student->student_id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
            ]);

            // Step 2: Generate the QR code as an SVG string.
            $qrCodeSvg = QrCode::size(250)->format('svg')->generate($qrData);

            // Step 3: Create the QR code record using the new student's ID and the generated SVG.
            $qrCodeRecord = StudentsQrCode::create([
                'student_id' => $student->id,
                'qr_code' => $qrCodeSvg,
            ]);

            // Step 4: Update the student record with the newly created qr_code_id.
            // $student->qr_code_id = $qrCodeRecord->id;
            $student->save();
        }
    }
}
