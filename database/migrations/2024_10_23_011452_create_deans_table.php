<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')
                    ->constrained('professors')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('faculty_id')
                    ->constrained('faculties')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->date('start_date')->default(now()); // Fecha de inicio como decano
            $table->date('end_date')->nullable(); // Fecha de fin, si cambia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deans');
    }
};
