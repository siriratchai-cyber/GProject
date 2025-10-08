<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'status')) {
                $table->dropColumn('status');
            }

            $table->enum('status', [
                'pending',          
                'approved',                   
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
