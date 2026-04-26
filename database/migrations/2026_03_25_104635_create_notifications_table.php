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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // මේ Notification එක කොයි ආයතනයටද අදාළ වෙන්නේ?
            // (Super Admin මුළු සිස්ටම් එකටම මැසේජ් එකක් ගැහුවොත් මේක හිස්ව තියන්න පුළුවන්, ඒ නිසා nullable දැම්මා)
            $table->foreignId('institute_id')->nullable()->constrained('institutes')->onDelete('cascade');

            // කාටද මැසේජ් එක යන්නේ? (Institute Owner ටද, Staff කෙනෙක්ටද?)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // නැත්නම් මැසේජ් එක යන්නේ ගුරුවරයෙක්ටද?
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('cascade');
            
            // මැසේජ් එකේ වර්ගය (උදා: 'salary_payment', 'system_alert', 'general')
            $table->string('type')->default('general'); 
            
            // -----------------------------------

            $table->string('message');
            $table->boolean('is_read')->default(false);
            
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
        Schema::dropIfExists('notifications');
    }
};