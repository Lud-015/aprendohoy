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
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuestionario_id'); // Cuestionario relacionado
            $table->foreign('cuestionario_id')->references('id')->on('cuestionarios');
            $table->unsignedBigInteger('estudiante_id'); // Estudiante que realizó el intento
            $table->foreign('estudiante_id')->references('id')->on('inscritos');
            $table->unsignedInteger('intento'); // Número de intento
            $table->double('puntaje_obtenido'); // Puntaje total obtenido
            $table->double('puntaje_total'); // Puntaje máximo posible
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
