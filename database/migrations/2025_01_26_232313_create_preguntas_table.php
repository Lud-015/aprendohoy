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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuestionario_id');
            $table->foreign('cuestionario_id')->references('id')->on('cuestionarios');
            $table->text('pregunta'); // Texto de la pregunta
            $table->enum('tipo', ['multiple', 'abierta', 'verdadero_falso'])->default('multiple'); // Tipo de pregunta
            $table->double('puntos'); // Puntos por responder esta pregunta
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
