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
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del parque
            $table->string('location'); // Dirección o ubicación textual
            $table->decimal('latitude', 9, 6); // Latitud para el marker en el mapa
            $table->decimal('longitude', 9, 6); // Longitud para el marker en el mapa
            $table->text('opening_hours')->nullable(); // Horario de apertura
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks');
    }
};
