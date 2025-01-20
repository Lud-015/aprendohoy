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
        Schema::create('respuesta_tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_id');
            $table->foreign('pregunta_id')->references('id')->on('pregunta_tareas')->onDelete('cascade');
            $table->text('texto_respuesta');
            $table->boolean('es_correcta');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuesta_tareas');
    }
};
