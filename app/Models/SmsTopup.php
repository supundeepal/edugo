<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTopup extends Model
{
    use HasFactory;
    protected $guarded = []; // හැම ෆීල්ඩ් එකකටම ඩේටා දාන්න දෙනවා
}