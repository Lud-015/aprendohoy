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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCurso');
            $table->string('descripcionC');
            $table->string('fecha_ini');
            $table->string('fecha_fin');
            $table->string('formato');
            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('users');
            $table->unsignedBigInteger('edadDir_id');
            $table->foreign('edadDir_id')->references('id')->on('edad_dirigidas');
            $table->unsignedBigInteger('niveles_id');
            $table->foreign('niveles_id')->references('id')->on('nivel');
            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios');
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
        Schema::dropIfExists('cursos');
    }
};
