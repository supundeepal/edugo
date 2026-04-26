<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // මේ ගෙවීම අයිති කොයි ආයතනයටද (ආදායම් වෙන් කරන්න)
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            // සල්ලි ගත්තේ කවුද? (Cashier/User) - මුදල් වංචා නවත්වන්න
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); 
            
            // මොන පන්තියටද ගෙව්වේ? (පන්තියෙන් පන්තියට ආදායම හොයන්න)
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // -----------------------------------

            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // සල්ලි ගෙවන ළමයා
            $table->decimal('amount', 8, 2); // ගෙවන ගාණ (උදා: 200.00 හෝ 1500.00)
            
            // ගෙවන විදිහ ('Daily', 'January', 'February' වගේ මාසේ නම හරි දවස හරි)
            // අපි කලින් කතා කළානේ Daily සහ Monthly පන්ති තියෙනවා කියලා
            $table->string('payment_type'); 
            
            $table->date('payment_date'); // ගෙවපු දවස
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};