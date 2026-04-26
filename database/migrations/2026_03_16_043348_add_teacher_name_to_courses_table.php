<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // මේකෙන් තමයි ගුරුවරයාගේ නම දාන තීරුව හැදෙන්නේ
            $table->string('teacher_name')->nullable()->after('course_name'); 
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('teacher_name');
        });
    }
};