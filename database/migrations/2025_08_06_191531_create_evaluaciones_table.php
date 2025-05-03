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
            $table->string('estado')->default('Activo');
            $table->boolean('es_cuestionario')->default(false);
            $table->integer('intentos_permitidos')->nullable();
            $table->unsignedBigInteger('cuestionario_id')->nullable();
            $table->foreign('cuestionario_id')->references('id')->on('cuestionarios')->onDelete('cascade');
            $table->unsignedBigInteger('cursos_id');
            $table->foreign('cursos_id')->references('id')->on('cursos');
            $table->unsignedBigInteger('temas_id'); 
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
