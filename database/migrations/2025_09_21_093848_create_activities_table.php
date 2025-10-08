<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');               
            $table->text('description')->nullable();       
            $table->date('date');                          
            $table->time('time');                          
            $table->string('location');                    
            $table->foreignId('club_id')->constrained()->onDelete('cascade'); 
            $table->string('status')->default('approved');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activities');
    }
};
