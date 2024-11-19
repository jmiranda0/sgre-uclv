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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('dni',11)->unique();
            $table->string('scholarship_card')->unique()->nullable();
            $table->boolean('is_foreign')->default(false);
            $table->foreignId('country_id')
                    ->nullable()
                    ->constrained('countries')
                    ->cascadeOnDelete();
            $table->foreignId('municipality_id')
                    ->nullable()
                    ->constrained('municipalities')
                    ->cascadeOnDelete();
            $table->foreignId('group_id')
                    ->nullable()
                    ->constrained('groups')
                    ->cascadeOnDelete();
            $table->foreignId('room_id')
                    ->nullable()
                    ->constrained('rooms')
                    ->cascadeOnDelete();
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
