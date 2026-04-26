<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // ⭐ මෙන්න මෙතනට institute_id එකයි, අනිත් අලුත් ඒවා ටිකයි දැම්මා
    protected $fillable = [
        'institute_id', // <-- මේක තමයි ප්‍රධානම එක
        'course_name', 
        'teacher_id', 
        'teacher_name', 
        'fee', 
        'fee_type'
    ];

    // මේ පන්තිය අයිති එක ගුරුවරයෙකුට විතරයි
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // මේ පන්තියට ළමයි ගොඩක් ඉන්නවා
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}