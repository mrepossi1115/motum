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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del entrenamiento
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade'); // Referencia a la tabla users
            $table->foreignId('park_id')->constrained('parks')->onDelete('cascade'); // Referencia a la tabla parks
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('activity_id')->on('activities')->onDelete('set null');
            $table->enum('level', ['básico', 'intermedio', 'avanzado'])->default('básico');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
