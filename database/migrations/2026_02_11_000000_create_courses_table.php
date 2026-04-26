<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            
            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // මේ පන්තිය අයිති කොයි ආයතනයටද
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            $table->string('course_name'); // පන්තියේ නම (උදා: Grade 10 Maths)
            
            // පන්තිය කරන සර් (Teacher)
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); 
            
            $table->decimal('fee', 8, 2)->default(0); // පන්ති ගාස්තුව
            
            // ගුරුවරයාගේ ප්‍රතිශතය (උපරිමය 100.00 යි. සාමාන්‍යයෙන් 80.00 ක් වැටෙන්න default දුන්නා)
            $table->decimal('teacher_percentage', 5, 2)->default(80.00); 
            
            // ගෙවීම් කරන ක්‍රමය (Monthly හෝ Daily)
            $table->string('fee_type')->default('Monthly'); 
            
            // -----------------------------------

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};