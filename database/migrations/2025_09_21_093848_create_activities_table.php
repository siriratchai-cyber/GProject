<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');               // ชื่อกิจกรรม
            $table->text('description')->nullable();       // รายละเอียด
            $table->date('date');                          // วันที่จัดกิจกรรม
            $table->time('time');                          // เวลา
            $table->string('location');                    // สถานที่
            $table->foreignId('club_id')->constrained()->onDelete('cascade'); // ของชมรมใด
            $table->string('status')->default('approved'); // approved / canceled
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activities');
    }
};
