<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // ลบของเดิมถ้ามีอยู่แล้ว
            if (Schema::hasColumn('members', 'status')) {
                $table->dropColumn('status');
            }

            // เพิ่ม enum ที่รองรับทุกสถานะที่ระบบใช้จริง
            $table->enum('status', [
                'pending',          // รออนุมัติเป็นสมาชิก
                'approved',         // ผ่านการอนุมัติแล้ว
                'pending_leader',   // รออนุมัติเป็นหัวหน้า
                'pending_resign',   // รออนุมัติการลาออก
                'rejected'          // ถูกปฏิเสธ
            ])->default('pending')
              ->after('role')
              ->comment('สถานะสมาชิกในชมรม');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
