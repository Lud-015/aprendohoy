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
            $table->text('descripcionTarea');
            $table->date('fecha_habilitacion');
            $table->date('fecha_vencimiento');
            $table->string('archivoTarea');
            $table->double('puntos');
            $table->enum('tipo_tarea', ['subida_archivo', 'cuestionario']); // Enumeración para indicar el tipo de tarea
            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos');
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
