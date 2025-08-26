<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsQrCode extends Model
{
    protected $fillable = ['qr_code_path', 'student_id'];

    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }
}
