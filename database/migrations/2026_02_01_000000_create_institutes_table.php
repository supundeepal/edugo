<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Foreign Key Security එක තාවකාලිකව නවත්වනවා (MySQL එකට ඇස් වහගන්න කියනවා 🤫)
        Schema::disableForeignKeyConstraints();
        
        // 2. දැන් කිසිම බාධාවක් නෑ, පරණ ටේබල් එක මකලා දානවා!
        Schema::dropIfExists('institutes');
        
        // 3. ආයෙත් Security එක On කරනවා
        Schema::enableForeignKeyConstraints();

        // 4. අපේ අලුත් සුපිරි ටේබල් එක ලස්සනට හදනවා
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('owner_name');
            $table->string('phone');
            $table->string('city');
            $table->string('status')->default('Active'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('institutes');
        Schema::enableForeignKeyConstraints();
    }
};