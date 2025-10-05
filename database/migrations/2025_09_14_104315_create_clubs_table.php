<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();               // ชื่อชมรม
            $table->text('description');                    // รายละเอียด
            $table->string('image')->nullable();            // รูปโปรไฟล์ชมรม
            $table->string('status')->default('pending');   // pending / approved
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clubs');
    }
};
