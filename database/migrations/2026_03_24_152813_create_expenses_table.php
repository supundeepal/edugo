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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // --- අලුතින් එකතු කළ SaaS කොටස් ---
            
            // මේ වියදම අයිති කොයි ආයතනයටද?
            $table->foreignId('institute_id')->constrained('institutes')->onDelete('cascade');
            
            // මේ වියදම සිස්ටම් එකට දැම්මේ කවුද? (User Tracking)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // -----------------------------------

            $table->string('category'); // ලයිට් බිල්, කුලිය වගේ දේවල්
            $table->decimal('amount', 10, 2); // වියදම් වුණු ගාණ
            $table->date('date'); // වියදම කරපු දවස
            $table->string('description')->nullable(); // අමතර විස්තරයක් (optional)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};