<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade'); // ความสัมพันธ์กับ club
            $table->string('name');                                           // ชื่อสมาชิก
            $table->string('student_id');                                     // std_id จาก accounts
            $table->string('role')->default('สมาชิก');                       // สมาชิก / หัวหน้าชมรม
            $table->string('status')->default('pending');                     // pending / approved / pending_leader / pending_resign
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('members');
    }
};
