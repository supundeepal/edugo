<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    use HasFactory;

    // හැම ෆීල්ඩ් එකකටම ඩේටා දාන්න දෙනවා
    protected $guarded = [];

    // ⭐ ආයතනයකට ගුරුවරු ගොඩක් ඉන්න පුළුවන් (Many-to-Many)
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'institute_teacher', 'institute_id', 'teacher_id')->withTimestamps();
    }
}