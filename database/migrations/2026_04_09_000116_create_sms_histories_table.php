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
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id');
            $table->string('course_name');
            $table->string('recipient_type');
            $table->text('message');
            $table->integer('audience_count');
            $table->integer('sms_parts');
            $table->decimal('total_cost', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_histories');
    }
};
