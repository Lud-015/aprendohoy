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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_evaluacion');
            $table->text('descripcionEvaluacion');
            $table->date('fecha_habilitacion');
            $table->date('fecha_vencimiento');
            $table->string('archivoEvaluacion');
            $table->double('puntos');
            $table->boolean('bloqueado')->default(true);
            $table->enum('tipo_evaluacion', ['subida_archivo', 'cuestionario']);
            $table->enum('estado', ['pendiente', 'en_progreso', 'completada'])->default('pendiente');
            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos');
            $table->unsignedBigInteger('temas_id'); // Clave foránea para la tabla temas
            $table->foreign('temas_id')->references('id')->on('temas');
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
