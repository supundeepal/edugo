<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();

            // --- අලුතින් එකතු කළ SaaS කොටස ---
            // මේ නිබන්ධනය අයිති කොයි ආයතනයටද කියලා ලින්ක් කිරීම
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            // -----------------------------------

            // මේකෙන් අදාළ පන්තියයි, ගුරුවරයාවයි ලින්ක් කරනවා
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            
            // ෆයිල් එකේ විස්තර
            $table->string('title');
            $table->string('file_path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_materials');
    }
};