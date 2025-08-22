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
        $numberOfStudents = 10;

        for ($i = 0; $i < $numberOfStudents; $i++) {
            // Step 1: Generate the temporary student ID and student data.
            $studentId = $faker->unique()->randomNumber(8);
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // Step 2: Create the student record first.
            // This is the crucial change. We create the student record before the QR code.
            $student = Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'student_id' => $studentId,
                // The 'qr_code_id' field on the student record can be set later.
            ]);

            // Step 3: Now we can create the QR code data using the student's ID from the newly created record.
            $qrData = json_encode([
                'student_id' => $student->id, // Use the real ID from the new student record
            ]);

            $qrCodePng = QrCode::size(250)->format('png')->generate($qrData);
            $fileName = 'qr-' . $student->id . '.png'; // Use the real student ID for a unique filename
            Storage::disk('public')->put($fileName, $qrCodePng);

            // Step 4: Create the QR code record, now with the student_id available.
            $qrCodeRecord = StudentsQrCode::create([
                'qr_code_path' => $fileName,
                'student_id' => $student->id, // Provide the student_id value here.
            ]);

            // $qrCodeRecord->student_id = $student->id;
            $qrCodeRecord->save();

            // Optional: Update the student record with the qr_code_id.
            // This links the student back to the QR code.
            $student->qr_code_id = $qrCodeRecord->id;
            $student->save();
        }
    }
}
