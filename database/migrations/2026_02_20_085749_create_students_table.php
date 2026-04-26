<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // --- අලුතින් එකතු කළ SaaS කොටස ---
            // මේ ළමයා අයිති කොයි ආයතනයටද කියලා ලින්ක් කිරීම
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            $table->string('student_name');    
            
            // Global Unique එක අයින් කළා (පහළින් ඒක හදලා තියෙනවා)
            $table->string('card_number'); 
            
            $table->string('parent_phone'); 
            
            // අපි photo එකත් කලින් පාවිච්චි කළා නේද? ඒකත් මෙතනම දැම්මා!
            $table->string('photo')->nullable(); 
            
            $table->string('status')->default('active'); 
            $table->timestamps();

            // --- SaaS මැජික් එක ---
            // ආයතනය ඇතුළේ විතරක් කාඩ් නම්බර් එක Unique වෙන්න ඕනේ කියලා සිස්ටම් එකට කියනවා
            $table->unique(['institute_id', 'card_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};