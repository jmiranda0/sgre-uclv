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
        Schema::create('group_advisors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')
                    ->constrained('professors')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('group_id')
                    ->constrained('groups')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->date('start_date')->default(now());
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_advisors');
    }
};
