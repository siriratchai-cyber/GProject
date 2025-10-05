<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            // ลบของเดิมถ้ามีอยู่แล้ว (ป้องกันซ้ำ)
            if (Schema::hasColumn('clubs', 'status')) {
                $table->dropColumn('status');
            }

            // เพิ่มคอลัมน์ใหม่ที่เป็น enum
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('image')
                  ->comment('สถานะชมรม: pending = รออนุมัติ, approved = ผ่าน, rejected = ไม่อนุมัติ');
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
