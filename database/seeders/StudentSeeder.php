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

            // Step 1: Generate the QR code data and the PNG file.
            // We create a temporary student ID to use in the QR code data.
            $studentId = $faker->unique()->randomNumber(8);
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $qrData = json_encode([
                'student_id' => $studentId,
                // 'first_name' => $firstName,
                // 'last_name' => $lastName,
            ]);

            $qrCodePng = QrCode::size(250)->format('png')->generate($qrData);
            $fileName = 'qr-' . $studentId . '.png'; // Use studentId to create a unique filename
            Storage::disk('public')->put($fileName, $qrCodePng);

            // Step 2: Create the QR code record first.
            // This provides the qr_code_id that the student record needs.
            $qrCodeRecord = StudentsQrCode::create([
                'qr_code_path' => $fileName,
            ]);

            // Step 3: Create the student record using the newly created qr_code_id.
            // The foreign key constraint is now satisfied.
            $student = Student::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'student_id' => $studentId,
                'qr_code_id' => $qrCodeRecord->id,
            ]);

            // Optional: Update the qr_code_record with the student's ID for linking.
            $qrCodeRecord->student_id = $student->id;
            $qrCodeRecord->save();
        }
    }
}
