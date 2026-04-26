<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // 'name' තීරුව හොයාගන්න බැරි Error එක හදන්න after() කෑල්ල අයින් කළා
            $table->decimal('arrears', 8, 2)->default(0.00); 
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('arrears');
        });
    }
};