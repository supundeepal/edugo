<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // කොයි ආයතනයේ පැමිණීමක්ද?
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            // මොන පන්තියටද ආවේ?
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // ඇත්තම ළමයාගේ රෙකෝඩ් එක ලින්ක් කිරීම
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            // කාඩ් එක ස්කෑන් කරපු කෙනා (Staff / User)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // -----------------------------------

            $table->string('card_number'); // ස්කෑන් කරපු කාඩ් අංකය (ඉක්මන් සෙවීම් වලට තියාගමු)
            
            // පැමිණි දවස විතරක් (Time එක නැතුව, හොයන්න ලේසි වෙන්න)
            $table->date('date'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};