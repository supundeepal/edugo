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
        Schema::create('sms_topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id'); // සල්ලි දැම්මේ මොන ආයතනයටද
            $table->decimal('amount', 10, 2); // දාපු ගාණ
            $table->string('reference_note')->nullable(); // බැංකු රිසිට් නම්බර් එක වගේ විස්තරයක්
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_topups');
    }
};
