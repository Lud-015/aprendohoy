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
        Schema::create('pregunta_tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id');
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
            $table->enum('tipo_preg', ['short', 'multiple', 'vf']); // Enumeración para indicar el tipo de tarea
            $table->text('texto_pregunta');
            $table->integer('puntos');
            $table->timestamps();
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
        Schema::dropIfExists('pregunta_tareas');
    }
};
