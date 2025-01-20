<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_evaluacion_id');
            $table->foreign('pregunta_evaluacion_id')->references('id')->on('pregunta_evaluaciones')->onDelete('cascade');
            $table->text('texto_respuesta');
            $table->boolean('es_correcta');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta_evaluacions');
    }
};
