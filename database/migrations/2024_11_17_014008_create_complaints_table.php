<?php

use App\Enums\ComplaintStatusEnum;
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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->text('text');
            $table->enum('status', ComplaintStatusEnum::getValues())  // Usamos el enum de ComplaintStatus
                  ->default(ComplaintStatusEnum::PENDING->value);  // Valor predeterminado
            $table->foreignId('student_id')
                    ->constrained('students')
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
        Schema::dropIfExists('complaints');
    }
};
