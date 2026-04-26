<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionClass extends Model
{
    use HasFactory;

    // Database එකට දාන්න පුළුවන් දේවල්
    protected $fillable = [
        'teacher_id',
        'subject_name',
        'grade',
        'teacher_fee_percentage',
    ];

    // මේ පන්තිය අයිති එක ගුරුවරයෙක්ටයි
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // මේ පන්තියට ළමයි ගොඩක් ඉන්න පුළුවන් (Many-to-Many)
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}