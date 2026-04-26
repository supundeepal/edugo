<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'date',
        'time',
        'user_id',
        'institute_id',
        'card_number'
    ];

    // Attendance එක අයිති ළමයා (Student)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Attendance එක අයිති පන්තිය (Course)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}