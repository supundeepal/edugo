<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('institutes', function (Blueprint $table) {
            // ආයතනයේ sms balance එක, මුලින්ම බිංදුවයි
            $table->decimal('sms_balance', 10, 2)->default(0.00); 
        });
    }

    public function down()
    {
        Schema::table('institutes', function (Blueprint $table) {
            $table->dropColumn('sms_balance');
        });
    }
};