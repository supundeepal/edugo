<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // ඔයාගේ පරණ කෑල්ල එහෙම්මම තියෙනවා
    protected $fillable = ['name', 'phone', 'username', 'password', 'photo'];

    // ⭐ අලුත් කෑල්ල: ගුරුවරයෙකුට ආයතන කීපයක් තියෙන්න පුළුවන් (Many-to-Many)
    public function institutes()
    {
        return $this->belongsToMany(Institute::class, 'institute_teacher', 'teacher_id', 'institute_id')->withTimestamps();
    }

    // ගුරුවරයෙකුට පන්ති ගොඩක් තියෙන්න පුළුවන්
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}