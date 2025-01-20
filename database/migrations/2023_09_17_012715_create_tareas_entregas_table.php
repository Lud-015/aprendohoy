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
        Schema::create('tareas_entregas', function (Blueprint $table) {
            $table->id();
            $table->string('MensajeEntrega')->default('Entregado');
            $table->string('ArchivoEntrega');
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('users');
            $table->unsignedBigInteger('tarea_id');
            $table->foreign('tarea_id')->references('id')->on('tareas');
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
        Schema::dropIfExists('tareas_entregas');
    }
};
