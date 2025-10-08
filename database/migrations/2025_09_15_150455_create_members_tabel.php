<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade'); 
            $table->string('name');                                           
            $table->string('student_id');                                     
            $table->string('role')->default('สมาชิก');                       
            $table->string('status')->default('pending');                     
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('members');
    }
};
