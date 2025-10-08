<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            if (Schema::hasColumn('clubs', 'status')) {
                $table->dropColumn('status');
            }

            $table->enum('status', ['pending', 'approved'])
                  ->default('pending')
                  ->after('image')
                  ->comment('สถานะชมรม: pending = รออนุมัติ, approved = ผ่าน');
        });
    }

    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
