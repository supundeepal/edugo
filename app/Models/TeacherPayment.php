<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TeacherPayment extends Model
{
    protected $fillable = ['course_id', 'month', 'amount'];

    public function course() {
        return $this->belongsTo(Course::class);
    }
}