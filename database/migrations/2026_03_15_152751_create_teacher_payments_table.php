<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_payments', function (Blueprint $table) {
            $table->id();

            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // පඩි ගෙවන ආයතනය
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            // පඩි ලබන ගුරුවරයා
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            
            // අදාළ පන්තිය
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // පඩි ගෙවීම සිස්ටම් එකට ඇතුළත් කළේ කවුද? (මුදල් ආරක්‍ෂාවට)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // -----------------------------------

            $table->string('month'); // උදා: '2026-April'
            $table->decimal('amount', 10, 2); // ගෙවපු ගාණ
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_payments');
    }
};