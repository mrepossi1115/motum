<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_trainers_have_parks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersHaveParksTable extends Migration
{
    public function up()
    {
        Schema::create('trainers_have_parks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_detail_id')->constrained('trainer_details')->onDelete('cascade');
            $table->foreignId('park_id')->constrained('parks')->onDelete('cascade');
            $table->boolean('is_default')->default(false); // Indica si es el parque predeterminado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainers_have_parks');
    }
}
