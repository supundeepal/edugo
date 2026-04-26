<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'teacher_id', 'title', 'file_path'];

    // අදාළ පන්තිය
    public function course() {
        return $this->belongsTo(Course::class);
    }

    // අදාළ ගුරුවරයා
    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}