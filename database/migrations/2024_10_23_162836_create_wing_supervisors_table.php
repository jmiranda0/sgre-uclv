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
        Schema::create('wing_supervisors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')
                    ->constrained('professors')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('wing_id')
                    ->constrained('wings')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wing_supervisors');
    }
};
