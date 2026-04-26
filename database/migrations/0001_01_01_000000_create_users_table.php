<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. අලුතින් එකතු කළ ආයතන (Institutes) Table එක
        // මේක උඩින්ම තියෙන්න ඕනේ, එතකොටයි Users ලව මේකට ලින්ක් කරන්න පුළුවන්.
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ආයතනයේ නම (උදා: Smart Institute)
            $table->string('logo')->nullable(); // ආයතනයේ ලෝගෝ එක
            $table->string('address')->nullable(); // ලිපිනය
            $table->string('phone')->nullable(); // දුරකථන අංකය
            $table->boolean('is_active')->default(true); // සිස්ටම් එක ලොක් කරන්න ඕන වුණොත්
            $table->timestamps();
        });

        // 2. වෙනස් කරපු Users Table එක
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('owner'); // මෙයාගේ තනතුර
$table->integer('institute_id')->nullable(); // අයිති ආයතනයේ ID එක
            
            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // Role එක (superadmin, owner, staff)
            $table->string('role')->default('staff'); 
            
            // ආයතනයට ලින්ක් කිරීම (Superadmin ට හිස්ව තියන්න පුළුවන් නිසා nullable කළා)
            $table->foreignId('institute_id')->nullable()->constrained('institutes')->onDelete('cascade');
            
            // රිසෙප්ෂන් අයට දෙන බලතල (Tick දාන ඒවා සේව් වෙන්නේ මෙතන)
            $table->json('permissions')->nullable(); 
            
            // -----------------------------------

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        // අන්තිමට institutes එක මකනවා (Reverse Order)
        Schema::dropIfExists('institutes'); 
    }
};