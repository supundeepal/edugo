<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // ⭐ මුලින්ම තියෙන එක මකනවා
        Schema::dropIfExists('institute_teacher');

        // ඊටපස්සේ අලුතින් හදනවා
        Schema::create('institute_teacher', function (Blueprint $table) {
            $table->id();
            
            // ආයතනයේ ID එකයි, ගුරුවරයාගේ ID එකයි
            $table->foreignId('institute_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            
            // එකම ගුරුවරයා එකම ආයතනයට දෙපාරක් ඇඩ් වෙන එක නවත්තන්න
            $table->unique(['institute_id', 'teacher_id']); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_teacher');
    }
};