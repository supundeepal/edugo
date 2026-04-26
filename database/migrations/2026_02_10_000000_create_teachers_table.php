<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. මුළු සිස්ටම් එකටම පොදු ගුරුවරුන්ගේ ටේබල් එක (Global Teachers)
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ගුරුවරයාගේ නම
            $table->string('phone')->nullable(); // ෆෝන් නම්බර් එක
            
            // ලොග් වෙන්න නම (මුළු සිස්ටම් එකේම මේක Unique වෙන්න ඕනේ)
            $table->string('username')->unique(); 
            $table->string('password'); // ලොග් වෙන්න පාස්වර්ඩ් එක
            
            $table->timestamps();
        });

        // 2. --- SaaS මැජික් එක ---
        // ආයතනය සහ ගුරුවරයා සම්බන්ධ කරන ටේබල් එක (Pivot Table)
        Schema::create('institute_teacher', function (Blueprint $table) {
            $table->id();
            
            // කොයි ආයතනයද?
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            // කොයි ගුරුවරයාද?
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            
            $table->timestamps();

            // එකම ගුරුවරයා එකම ආයතනයට දෙපාරක් ඇතුළත් වෙන එක නවත්වන්න
            $table->unique(['institute_id', 'teacher_id']);
        });
    }

    public function down()
    {
        // මකද්දී අලුත් එක (Pivot Table) මුලින්ම මකන්න ඕනේ
        Schema::dropIfExists('institute_teacher');
        Schema::dropIfExists('teachers');
    }
};