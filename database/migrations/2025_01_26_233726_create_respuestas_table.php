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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_id'); // La pregunta respondida
            $table->foreign('pregunta_id')->references('id')->on('preguntas');
            $table->unsignedBigInteger('estudiante_id'); // El estudiante que responde
            $table->foreign('estudiante_id')->references('id')->on('inscritos');
            $table->string('respuesta')->nullable(); // La respuesta del estudiante (para preguntas abiertas)
            $table->unsignedBigInteger('opcion_id')->nullable(); // Opción seleccionada (para preguntas de opción múltiple)
            $table->foreign('opcion_id')->references('id')->on('opciones');
            $table->unsignedInteger('intento')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
