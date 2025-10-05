<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('std_id')->unique();             // รหัสนักศึกษา (Primary unique)
            $table->string('std_name');                     // ชื่อ-นามสกุล
            $table->string('email')->unique();              // อีเมล
            $table->string('password');                     // ✅ รหัสผ่านแบบ string ไม่เข้ารหัส
            $table->string('major');                        // สาขา
            $table->string('role')->default('นักศึกษา');    // นักศึกษา / หัวหน้าชมรม / แอดมิน
            $table->integer('year')->nullable();            // ชั้นปี
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('accounts');
    }
};
