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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_tarea');
            $table->text('descripcion_tarea')->nullable();
            $table->date('fecha_habilitacion');
            $table->date('fecha_vencimiento');
            $table->string('archivo_requerido')->nullable(); // Archivo requerido para la tarea
            $table->double('puntos'); // Puntos de la tarea
            $table->unsignedBigInteger('subtema_id'); // Relación con el subtema
            $table->foreign('subtema_id')->references('id')->on('subtemas');
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
        Schema::dropIfExists('tareas');
    }
};
