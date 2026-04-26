<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'institute_id', // ⭐ මෙන්න මේකයි අනිවාර්යයෙන්ම ඕනේ! (මේක තමයි ඇඩ් කළේ)
        'student_name',
        'grade_course',
        'card_number',
        'phone',        
        'parent_phone',
        'photo',
        'arrears'
    ];

    // එක ළමයෙක්ට පන්ති ගොඩකට යන්න පුළුවන්
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}