<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cleaning_schedule_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cleaning_schedule_id')
                    ->constrained('cleaning_schedules')
                    ->cascadeOnDelete();
            $table->foreignId('student_id')
                    ->constrained('students')
                    ->cascadeOnDelete(); 
            $table->enum("evaluation",["Bien", "Regular", "Mal"])->nullable(); 
            $table->text('comments')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaning_schedule_students');
    }
};
